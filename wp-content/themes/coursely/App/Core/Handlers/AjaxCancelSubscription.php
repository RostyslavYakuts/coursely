<?php

namespace coursely\App\Core\Handlers;

use coursely\App\Core\Helpers\CheckoutHelper;
use coursely\App\Core\Helpers\NonceChecker;
use Stripe\StripeClient;
use Exception;

class AjaxCancelSubscription
{
    private string $table;
    private StripeClient $stripe;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        global $wpdb;

        $this->table = $wpdb->prefix . 'coursely_subscriptions';
        $this->stripe = CheckoutHelper::getStripeClient();
        add_action('wp_ajax_cancel_subscription', [$this, 'handle']);
    }

    public function handle(): void
    {

        try {
            NonceChecker::check('cancel_subscription');

            if (!is_user_logged_in()) {
                wp_send_json_error(['message' => 'You must be logged in to cancel subscription.'], 401);
            }

            $subscriptionId = sanitize_text_field(wp_unslash($_POST['subscription_id'] ?? ''));

            if (empty($subscriptionId)) {
                wp_send_json_error(['message' => 'Subscription ID is missing.'], 400);
            }

            $subscription = $this->stripe->subscriptions->retrieve($subscriptionId);

            $this->assertUserOwnsSubscription($subscription);

            $updatedSubscription = $this->stripe->subscriptions->update($subscriptionId, [
                'cancel_at_period_end' => true
            ]);
            $cancelDate = $updatedSubscription->current_period_end
                ?? ($updatedSubscription->items->data[0]->current_period_end ?? null);


            $this->updateLocalSubscription($subscriptionId, $cancelDate);


            wp_send_json_success([
                'message' => 'Subscription scheduled for cancellation.',
                'active_until' => date('Y-m-d H:i:s', $cancelDate),
                'cancel_at_period_end' => $updatedSubscription->cancel_at_period_end
            ]);

        } catch (Exception $e) {

            error_log('CANCEL SUB ERROR: ' . $e->getMessage());
            wp_send_json_error([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if subscription belongs to current user
     */
    private function assertUserOwnsSubscription(object $subscription): void
    {
        $userId = get_current_user_id();
        $stripeCustomerId = get_user_meta($userId, 'stripe_customer_id', true);

        if (empty($stripeCustomerId)) {
            throw new Exception('User Stripe customer ID not found.');
        }

        if (empty($subscription->customer) || $subscription->customer !== $stripeCustomerId) {
            throw new Exception('You do not have permission to cancel this subscription.');
        }
    }

    /**
     * Renew db WordPress
     */
    private function updateLocalSubscription(string $subscriptionId, bool $cancelAtPeriodEnd): void
    {
        global $wpdb;

        $wpdb->update(
            $this->table,
            [
                'cancel_at_period_end' => $cancelAtPeriodEnd ? 1 : 0,
            ],
            ['stripe_subscription_id' => $subscriptionId],
            ['%d'], // format for cancel_at_period_end
            ['%s']  // format for where clause
        );

        if ($wpdb->last_error) {
            error_log('DB Update Error: ' . $wpdb->last_error);
            throw new Exception('Failed to update local subscription record.');
        }
    }
}