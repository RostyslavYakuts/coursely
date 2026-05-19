<?php

namespace coursely\App\Core\Cron;

use coursely\App\Core\Repositories\SubscriptionRepository;
use coursely\App\Core\Services\SubscriptionMailer;

class SubscriptionReminderCron extends AbstractCron
{
    protected string $hook = 'coursely_subscription_reminder';
    public function handle(): void
    {
        $repository = new SubscriptionRepository();
        $mailer = new SubscriptionMailer();

        $subscriptions = $repository->getSubscriptionsEndingInDays(3);

        foreach ($subscriptions as $subscription) {

            $user = get_user_by('id', $subscription->user_id);

            if (!$user) {
                continue;
            }

            $sent = get_field('subscription_reminder_sent', 'user_' . $user->ID);

            if ($sent) {
                continue;
            }

            $mailer->sendRenewalReminder(
                $user->user_email,
                $subscription->plan_name,
                $subscription->current_period_end
            );

            update_field('subscription_reminder_sent', true, 'user_' . $user->ID);

        }
    }
}