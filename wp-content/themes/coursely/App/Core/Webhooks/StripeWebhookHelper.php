<?php

namespace coursely\App\Core\Webhooks;

use coursely\App\Core\Helpers\CheckoutHelper;
use Stripe\StripeClient;

class StripeWebhookHelper
{
    private const string TABLE = 'coursely_subscriptions';

    public function getWebhookSecret(): string
    {
        return (string) get_field('stripe_webhook_secret', 'options');
    }

    public function eventProcessed(string $eventId): bool
    {
        return (bool) get_transient('stripe_event_' . $eventId);
    }

    public function markProcessed(string $eventId): void
    {
        set_transient('stripe_event_' . $eventId, true, DAY_IN_SECONDS * 2);
    }

    /**
     * ==============================
     * EVENT: payment_intent.succeeded
     * ==============================
     */
    public function handlePaymentIntentSucceeded(object $paymentIntent): void
    {
        error_log('Payment Intent Succeeded');
        //error_log(print_r($paymentIntent, true));
    }

    /**
     * ==============================
     * EVENT: payment_intent.canceled
     * ==============================
     */
    public function handlePaymentCanceled(object $paymentIntent): void
    {
        error_log('PAYMENT CANCELED');
        error_log(print_r($paymentIntent, true));
    }

    /**
     * ==============================
     * EVENT: invoice.paid
     * ==============================
     * @throws \Exception
     */
    public function handleInvoicePaid(object $invoice): void
    {
        if (empty($invoice->subscription)) {
            return;
        }

        $billingReason = $invoice->billing_reason ?? null;
        $stripe = $this->getStripeClient();

        try {
            $subscription = $stripe->subscriptions->retrieve($invoice->subscription);
        } catch (\Exception $e) {
            error_log('Stripe Sub Retrieve Error: ' . $e->getMessage());
            return;
        }

        $signupToken = $subscription->metadata->signup_token ?? null;

        // =========================
        // NEW SUBSCRIPTION FLOW
        // =========================
        if ($billingReason === 'subscription_create') {
            $data = $signupToken ? get_transient('coursely_signup_' . $signupToken) : null;
            $userId = email_exists($data['email']);
            if (!$userId) {
                $userId = wp_insert_user([
                    'user_login'   => $data['email'],
                    'user_email'   => $data['email'],
                    'user_pass'    => $data['password'],
                    'display_name' => $data['name'],
                    'first_name'  => $data['name'],
                    'role'         => 'subscriber'
                ]);
                if (is_wp_error($userId)) {
                    error_log('User Creation Error: ' . $userId->get_error_message());
                    return;
                }
                if($data){
                    $this->sendWelcomeEmail($data['email'],$data['password']);
                }
            }
            if($data){
                error_log(print_r($data,true));
                update_field( 'stripe_customer_id', $subscription->customer,'user_'.$userId);
                update_field('phone', $data['phone'], 'user_' . $userId);
                update_field('cardholder_name', $data['cardholder_name'], 'user_' . $userId);
                update_field('company', $data['company'], 'user_' . $userId);
                update_field('address_line_1', $data['address']['line1'], 'user_' . $userId);
                update_field('address_line_2', $data['address']['line2'], 'user_' . $userId);
                update_field('city', $data['address']['city'], 'user_' . $userId);
                update_field('state', $data['address']['state'], 'user_' . $userId);
                update_field('postal_code', $data['address']['postal_code'], 'user_' . $userId);
                update_field('country', $data['address']['country'], 'user_' . $userId);
                update_field('country_code', $data['address']['country_code'], 'user_' . $userId);
            }

            $this->syncSubscription($userId, $subscription);
            $this->saveInvoice($invoice, $subscription, $userId);
        }
        // =========================
        // PLAN CHANGE / UPGRADE
        // =========================
        $userId = $this->findUserByStripeCustomer($subscription->customer);
        if ($billingReason === 'subscription_update') {
            if (!$userId) {
                error_log('User not found for subscription_update');
                return;
            }
            $this->syncSubscription($userId, $subscription);
            $this->saveInvoice($invoice, $subscription, $userId);
            return;
        }

        // =========================
        // DEFAULT SAFE PATH
        // =========================

        if ($userId) {
            $this->syncSubscription($userId, $subscription);
            $this->saveInvoice($invoice, $subscription, $userId);
        }
        if ($signupToken) {
            //delete_transient('coursely_signup_' . $signupToken);
            error_log('Stripe Signup Token: ' . $signupToken);
        }
    }

    /**
     * ==============================
     * EVENT: invoice.payment_failed
     * ==============================
     */
    public function handlePaymentFailed(object $invoice): void
    {
        if (empty($invoice->subscription)) {
            return;
        }

        $subscriptionId = $invoice->subscription;

        // Getting user_id for mail notif
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE;
        $userId = $wpdb->get_var($wpdb->prepare(
            "SELECT user_id FROM $table WHERE stripe_subscription_id = %s",
            $subscriptionId
        ));

        $this->updateStatusBySubscription($invoice->subscription, 'payment_failed');
        if ($userId) {
            // Send email to user
            wp_mail(
                get_the_author_meta('user_email', $userId),
                'Payment Failed for your subscription',
                'We were unable to charge your card. Please update your payment method.'
            );
        }
    }

    /**
     * ==============================
     * EVENT: subscription.updated
     * ==============================
     * @throws \Exception
     */
    public function handleSubscriptionUpdated1(object $subscription): void
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE;

        $userId = $wpdb->get_var($wpdb->prepare(
            "SELECT user_id FROM $table WHERE stripe_subscription_id = %s",
            $subscription->id
        ));
        error_log('handleSubscriptionUpdated' . $userId);
        if ($userId) {
            // 1. Оновлюємо саму підписку
            $this->syncSubscription($userId, $subscription);

            // 2. ЗБЕРІГАЄМО ІНВОЙС (Логіка для Upgrade/Downgrade)
            if (!empty($subscription->latest_invoice)) {
                try {
                    $stripe = $this->getStripeClient();

                    // latest_invoice може бути ID або об'єктом, приводимо до ID
                    $invoiceId = is_string($subscription->latest_invoice)
                        ? $subscription->latest_invoice
                        : $subscription->latest_invoice->id;

                    // Отримуємо повний об'єкт інвойсу
                    $invoice = $stripe->invoices->retrieve($invoiceId);

                    // Зберігаємо в таблицю coursely_invoices
                    $this->saveInvoice($invoice, $subscription, $userId);

                } catch (\Exception $e) {
                    error_log('Failed to save invoice on subscription update: ' . $e->getMessage());
                }
            }
        }
    }
    public function handleSubscriptionUpdated(object $subscription): void
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE;

        $userId = $wpdb->get_var($wpdb->prepare(
            "SELECT user_id FROM $table WHERE stripe_subscription_id = %s",
            $subscription->id
        ));

        error_log('handleSubscriptionUpdated userId: ' . $userId);

        if (!$userId) {
            return;
        }

        // 1. sync subscription state always
        $this->syncSubscription($userId, $subscription);

        /**
         * ==========================
         * CANCEL FLOW
         * ==========================
         */
        if (!empty($subscription->cancel_at_period_end)) {
            error_log('Subscription scheduled cancel: ' . $subscription->id);
            return;
        }

        /**
         * ==========================
         * UPGRADE / DOWNGRADE FLOW
         * ==========================
         */
        if (!empty($subscription->latest_invoice)) {

            try {
                $stripe = $this->getStripeClient();

                $invoiceId = is_string($subscription->latest_invoice)
                    ? $subscription->latest_invoice
                    : $subscription->latest_invoice->id;

                $invoice = $stripe->invoices->retrieve(
                    $invoiceId,
                    [
                        'expand' => ['payment_intent']
                    ]
                );

                // ❗ зберігаємо тільки реальні платежі
                if (($invoice->amount_paid ?? 0) > 0 && $invoice->status === 'paid') {
                    $this->saveInvoice($invoice, $subscription, $userId);
                }

            } catch (\Exception $e) {
                error_log('Failed to save invoice on subscription update: ' . $e->getMessage());
            }
        }
    }

    /**
     * ==============================
     * EVENT: subscription.deleted
     * ==============================
     */
    public function handleSubscriptionDeleted(object $subscription): void
    {
        $end = $subscription->current_period_end
            ?? ($subscription->items->data[0]->current_period_end ?? null);

        $this->updateStatusBySubscription(
            $subscription->id,
            'canceled',
            $end ?: current_time('timestamp')
        );
    }

    /**
     * ==============================
     * SYNC DB
     * ==============================
     * @throws \Exception
     */
    private function syncSubscription(int $userId, object $subscription): void
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE;

        $priceData = $subscription->items->data[0]->price;
        $priceId = $priceData->id;
        $planName = CheckoutHelper::getPlanByPlanStripePriceId($priceId)['name'];

        $data = [
            'user_id' => $userId,
            'stripe_subscription_id' => $subscription->id,
            'stripe_customer_id' => $subscription->customer,
            'stripe_price_id' => $priceId,
            'plan_name' => $planName,
            'plan_interval' => $subscription->items->data[0]->price->recurring->interval,
            'status' => $subscription->status,
            'current_period_start' => date('Y-m-d H:i:s', $subscription->items->data[0]->current_period_start),
            'cancel_at_period_end' => $subscription->cancel_at_period_end ? 1 : 0,
        ];
        if (!$subscription->cancel_at_period_end) {
            error_log('Updating subscription cancel date: ' .$subscription->cancel_at_period_end);
            $data['current_period_end'] = date('Y-m-d H:i:s', $subscription->items->data[0]->current_period_end);
        }

        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table WHERE stripe_subscription_id = %s",
            $subscription->id
        ));

        if ($exists) {
            $wpdb->update($table, $data, ['id' => $exists]);
        } else {
            $wpdb->insert($table, $data);
        }
    }

    /**
     * @throws \Exception
     */
    public function saveInvoice(object $invoice, $subscription, $userId): void
    {
        global $wpdb;

        $table = $wpdb->prefix . 'coursely_invoices';

        // Check UNIQUE KEY stripe_invoice_id
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table WHERE stripe_invoice_id = %s",
            $invoice->id
        ));
        if ($exists) {
            return;
        }
        if ($invoice->status !== 'paid' || ($invoice->amount_paid ?? 0) <= 0) {
            error_log('StripeWebhookHandler:  Save invoice(): $invoice->status !== paid' . print_r($invoice, true));
        }
        $item = $subscription->items->data[0] ?? null;
        $planName = '';
        if ($item) {
            $planData = CheckoutHelper::getPlanByPlanStripePriceId($item->price->id);
            $planName = $planData['name'] ?? '';
        }
        error_log('StripeWebhookHandler:  Save invoice(): ' . print_r($invoice, true));
        $data = [
            'user_id' => $this->getUserIdByCustomerId($invoice->customer) ?? $userId, //must match wp user id
            'stripe_invoice_id' => $invoice->id,
            'stripe_payment_intent_id' => $invoice->payment_intent ?? null,
            'stripe_subscription_id' => $invoice->subscription ?? null,
            'total' => $invoice->amount_paid / 100,
            'currency' => $invoice->currency,
            'status' => $invoice->status,
            'type' => $invoice->billing_reason ?? null,
            'invoice_url' => $invoice->invoice_pdf ?? null,
            'hosted_invoice_url' => $invoice->hosted_invoice_url ?? null,
            'metadata' => maybe_serialize($invoice->metadata ?? []),
            'paid_at' => !empty($invoice->status_transitions->paid_at)
                ? date('Y-m-d H:i:s', $invoice->status_transitions->paid_at)
                : null,
            'refunded_at' => null,
            'plan_name' => $planName,
            'plan_interval' => $item?->price?->recurring?->interval,
        ];

        $wpdb->insert($table, $data);
    }

    private function getUserIdByCustomerId(string $customerId): ?int
    {
        $users = get_users([
            'meta_key' => 'stripe_customer_id',
            'meta_value' => $customerId,
            'number' => 1
        ]);

        return $users[0]->ID ?? null;
    }

    private function findUserByStripeCustomer(string $stripeCustomerId): ?int
    {
        if (empty($stripeCustomerId)) {
            return null;
        }

        global $wpdb;

        // ACF field: stripe_customer_id stored in usermeta
        $userId = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT user_id 
             FROM {$wpdb->usermeta}
             WHERE meta_key = %s
             AND meta_value = %s
             LIMIT 1",
                'stripe_customer_id',
                $stripeCustomerId
            )
        );

        return $userId ? (int) $userId : null;
    }

    private function updateStatusBySubscription(string $subscriptionId, string $status, ?int $endedAt = null): void
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE;
        $updateData = ['status' => $status];
        if ($endedAt) {
            $updateData['ended_at'] = date('Y-m-d H:i:s', $endedAt);
        } elseif ($status === 'canceled' || $status === 'payment_failed') {
            // If no date but status is canceled use timestamp now
            $updateData['ended_at'] = current_time('mysql');
        }
        $wpdb->update($table,$updateData, ['stripe_subscription_id' => $subscriptionId]);
    }

    private function getStripeClient(): StripeClient
    {
        return new StripeClient((string) get_field('stripe_secret_key', 'options'));
    }

    private function sendWelcomeEmail(string $email, $password): void
    {
        $subject = 'Welcome to Coursely! Account Created';
        $message = "Your account has been created successfully.\r\n\r\n";
        $message .= "Email: " . $email . "\r\n";
        $message .= "Password: " . $password . "\r\n\r\n";
        $message .= "Please log in to access your courses.";

        wp_mail($email, $subject, $message);
    }

}