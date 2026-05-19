<?php

namespace coursely\App\Core\Cron;

use coursely\App\Core\Repositories\SubscriptionRepository;

class SubscriptionStatusCron extends AbstractCron
{
    protected string $hook = 'coursely_subscription_status_check';

    public function handle(): void
    {
        $repository = new SubscriptionRepository();

        $subscriptions = $repository->getExpiredSubscriptions();

        foreach ($subscriptions as $subscription) {

            /**
             * cancel_at_period_end = 1
             * user canceled
             */
            if ((int)$subscription->cancel_at_period_end === 1) {

                $repository->updateStatus(
                    $subscription->id,
                    'cancelled'
                );

                continue;
            }

            /**
             * Stripe did not charge a money
             */
            $repository->updateStatus(
                $subscription->id,
                'past_due'
            );
        }
    }
}