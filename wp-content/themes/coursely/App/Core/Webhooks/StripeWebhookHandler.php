<?php

namespace coursely\App\Core\Webhooks;

use Stripe\Webhook;

class StripeWebhookHandler
{
    public function __construct()
    {
        add_action(
            'admin_post_nopriv_stripe_webhook',
            [$this, 'handle_webhook']
        );

        add_action(
            'admin_post_stripe_webhook',
            [$this, 'handle_webhook']
        );
    }

    public function handle_webhook(): void
    {
        $payload = file_get_contents('php://input');

        $signature =
            $_SERVER['HTTP_STRIPE_SIGNATURE']
            ?? '';

        $secret = get_field(
            'stripe_webhook_secret',
            'options'
        );

        try {

            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $secret
            );

        } catch (\Exception $e) {

            status_header(400);
            exit;
        }

        // Prevent duplicate processing
        if ($this->eventAlreadyProcessed($event->id)) {
            status_header(200);
            exit;
        }

        try {

            $this->processEvent($event);

            $this->markEventProcessed(
                $event->id
            );

        } catch (\Throwable $e) {

            error_log(
                'Stripe Webhook Error: '
                . $e->getMessage()
            );

            status_header(500);
            exit;
        }

        status_header(200);
        exit;
    }

    private function processEvent(
        object $event
    ): void {

        switch ($event->type) {

            case 'invoice.payment_succeeded':
                $this->handlePaymentSucceeded(
                    $event->data->object
                );
                break;

            case 'invoice.payment_failed':
                $this->handlePaymentFailed(
                    $event->data->object
                );
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionCancelled(
                    $event->data->object
                );
                break;
        }
    }

    private function eventAlreadyProcessed(
        string $event_id
    ): bool {

        return (bool) get_option(
            'stripe_event_' . $event_id
        );
    }

    private function markEventProcessed(
        string $event_id
    ): void {

        add_option(
            'stripe_event_' . $event_id,
            true,
            '',
            false
        );
    }
    public function handle_stripe_webhook(): void
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $endpoint_secret = 'whsec_...'; // Ваш секрет вебхуку з кабінету Stripe

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            status_header(400);
            exit();
        }

        // Обробляємо подію успішної оплати інвойсу підписки
        if ($event->type === 'invoice.paid') {
            $invoice = $event->data->object;

            // Ігноруємо поодинокі замовлення, нам потрібні лише підписки
            if (!empty($invoice->subscription)) {
                $customerEmail = $invoice->customer_email;
                $customerId    = $invoice->customer;

                // 1. Перевіряємо, чи існує вже юзер в WordPress
                $user_id = email_exists($customerEmail);

                if (!$user_id) {
                    // 2. Якщо юзера немає — створюємо його автоматично
                    $random_password = wp_generate_password(12, false);
                    $user_id = wp_create_user($customerEmail, $random_password, $customerEmail);

                    // 3. Зберігаємо Stripe Customer ID у метаполя юзера для майбутнього менеджменту
                    update_user_meta($user_id, 'stripe_customer_id', $customerId);
                    update_user_meta($user_id, 'stripe_subscription_id', $invoice->subscription);

                    // 4. Відправляємо email користувачу з його згенерованим паролем та лінком на курс
                    wp_new_user_notification($user_id, null, 'both');
                } else {
                    // Якщо юзер вже існує (наприклад, купує другий курс), просто оновлюємо його рівень доступу
                    update_user_meta($user_id, 'stripe_subscription_id', $invoice->subscription);
                }
            }
        }

        status_header(200);
        exit();
    }
}