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
}