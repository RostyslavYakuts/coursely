<?php

namespace coursely\App\Core\Webhooks;

use Stripe\Exception\SignatureVerificationException;
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

    public function handleWebhook(\WP_REST_Request $request): \WP_REST_Response
    {
        //$payload = file_get_contents('php://input');
        $payload = $request->get_body();
        $sig_header = $request->get_header( 'stripe_signature' );
        if ( empty( $sig_header ) ) {
            $sig_header = $request->get_header( 'stripe-signature' );
        }
        if ( empty( $sig_header ) ) {
            // Fallback to raw $_SERVER headers
            $sig_header = isset( $_SERVER['HTTP_STRIPE_SIGNATURE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_STRIPE_SIGNATURE'] ) ) : '';
        }

        if ( empty( $sig_header ) ) {
            error_log( 'Webhook signature header not found' );
            return new \WP_REST_Response( array( 'error' => 'Invalid request' ), 400 );
        }

        $signature = $sig_header;
        $secret = $this->helper->getWebhookSecret();
        if ( empty( $secret ) ) {
           error_log( 'Webhook secret not configured' );
            return new \WP_REST_Response( array( 'error' => 'Configuration error' ), 400 );
        }

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (\UnexpectedValueException $e) {
            error_log('PAYLOAD: ' . $payload);
            error_log('SIG: ' . $signature);
            error_log('SECRET: ' . $secret);
            error_log($e->getMessage());
            error_log('Stripe Webhook Signature Verification Failed: ' . $e->getMessage());
            return new \WP_REST_Response( array( 'error' => 'Invalid payload' ), 400 );
        }catch ( SignatureVerificationException $e ) {
            // Invalid signature
            error_log( 'Invalid webhook signature: ' . $e->getMessage() );
            error_log( 'Signature header present: ' . ( ! empty( $sig_header ) ? 'yes' : 'no' ) );
            error_log( 'Webhook secret configured: ' . ( ! empty( $webhook_secret ) ? 'yes' : 'no' ) );
            return new \WP_REST_Response( array( 'error' => 'Invalid signature' ), 400 );
        }

        error_log( 'Received webhook event: ' . $event->type );

        // idempotency
        if ($this->helper->eventProcessed($event->id)) {
            return new \WP_REST_Response( array( 'error' => 'Idempotency limitation' ), 200 );
        }

        try {
            $this->process($event);
            $this->helper->markProcessed($event->id);
        } catch (\Throwable $e) {
            error_log('Stripe webhook error: ' . $e->getMessage());
            return new \WP_REST_Response( array( 'error' => 'Stripe webhook error' ), 500 );
        }

        return new \WP_REST_Response(['status' => 'success'], 200);
    }

    /**
     * @throws \Exception
     */
    private function process(object $event): void
    {
        switch ($event->type) {

            case 'payment_intent.succeeded':
                $this->helper->handlePaymentIntentSucceeded($event->data->object);
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