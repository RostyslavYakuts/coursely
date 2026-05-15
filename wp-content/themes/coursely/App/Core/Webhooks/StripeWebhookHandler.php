<?php

namespace coursely\App\Core\Webhooks;

use Stripe\Webhook;

class StripeWebhookHandler
{
    private StripeWebhookHelper $helper;

    public function __construct()
    {
        $this->helper = new StripeWebhookHelper();

        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    public function registerRoutes(): void
    {
        register_rest_route('coursely/v1', '/stripe/webhook', [
            'methods'  => 'POST',
            'callback' => [$this, 'handleWebhook'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function handleWebhook(\WP_REST_Request $request): void
    {
        error_log('WEBHOOK HIT');
        error_log(print_r($request, true));
        //$payload = file_get_contents('php://input');
        $payload = $request->get_body();
        $signature = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $secret = $this->helper->getWebhookSecret();

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (\Throwable $e) {
            error_log('PAYLOAD: ' . $payload);
            error_log('SIG: ' . $signature);
            error_log('SECRET: ' . $secret);
            error_log($e->getMessage());
            error_log('Stripe Webhook Signature Verification Failed: ' . $e->getMessage());
            status_header(400);
            exit;
        }

        // idempotency
        if ($this->helper->eventProcessed($event->id)) {
            status_header(200);
            exit;
        }

        try {
            $this->process($event);
            $this->helper->markProcessed($event->id);
        } catch (\Throwable $e) {
            error_log('Stripe webhook error: ' . $e->getMessage());
            status_header(500);
            exit;
        }

        status_header(200);
        exit;
    }

    private function process(object $event): void
    {
        switch ($event->type) {

            case 'payment_intent.succeeded':
                $this->helper->handlePaymentSuccess($event->data->object);
                break;

            case 'payment_intent.canceled':
                $this->helper->handlePaymentCanceled($event->data->object);
                break;

            case 'invoice.paid':
                $this->helper->handleInvoicePaid($event->data->object);
                break;

            case 'invoice.payment_failed':
                $this->helper->handlePaymentFailed($event->data->object);
                break;

            case 'customer.subscription.updated':
                $this->helper->handleSubscriptionUpdated($event->data->object);
                break;

            case 'customer.subscription.deleted':
                $this->helper->handleSubscriptionDeleted($event->data->object);
                break;
        }
    }
}