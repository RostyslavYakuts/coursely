<?php

namespace coursely\App\Core\Services;

class SubscriptionMailer
{
    public function sendRenewalReminder(
        string $email,
        string $planName,
        string $endDate
    ): void {

        $subject = 'Subscription renewal reminder';

        $message = sprintf(
            'Your subscription "%s" will renew on %s. Funds will be charged automatically.',
            $planName,
            $endDate
        );

        wp_mail($email, $subject, $message);
    }
}