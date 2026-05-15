<?php

namespace coursely\App\Core\Services;

class AccessService
{
    public static function canViewLesson($userId, $lessonId): bool
    {
        if (current_user_can('administrator')) {
            return true;
        }

        if (!$userId) {
            return false;
        }

        return self::hasActiveSubscription($userId);
    }

    private static function hasActiveSubscription(int $userId): bool
    {
        global $wpdb;

        $table = $wpdb->prefix . 'coursely_subscriptions';

        $subscription = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT 1 
                 FROM {$table}
                 WHERE user_id = %d
                   AND status = 'active'
                   AND current_period_end > NOW()
                 LIMIT 1",
                $userId
            )
        );

        if (!$subscription) {
            return false;
        }

        if ($subscription->status !== 'active') {
            return false;
        }

        if (empty($subscription->current_period_end)) {
            return false;
        }

        return strtotime($subscription->current_period_end) > time();
    }

}