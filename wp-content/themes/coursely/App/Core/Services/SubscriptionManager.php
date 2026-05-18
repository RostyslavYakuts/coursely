<?php

namespace coursely\App\Core\Services;

class SubscriptionManager
{
    private static array $cache = [];

    public static function getUserSubscription($user_id) {
        if (isset(self::$cache[$user_id])) {
            return self::$cache[$user_id];
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'coursely_subscriptions';

        $sub = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name 
             WHERE user_id = %d 
             AND status IN ('active') 
             AND current_period_end > NOW() 
             ORDER BY current_period_end DESC LIMIT 1",
            $user_id
        ));

        self::$cache[$user_id] = $sub;
        return $sub;
    }

    public static function isActive($user_id): bool
    {
        return !empty(self::getUserSubscription($user_id));
    }

    public static function getActivePlan(int $user_id): ?object {

        $subscription = self::getUserSubscription($user_id);

        if (!$subscription) {
            return null;
        }

        return (object) [
            'plan_name' => $subscription->plan_name,
            'plan_interval' => $subscription->plan_interval,
            'stripe_price_id' => $subscription->stripe_price_id,
            'expires_at' => $subscription->current_period_end,
            'stripe_subscription_id' => $subscription->stripe_subscription_id,
            'cancel_at_period_end' => $subscription->cancel_at_period_end,
            'current_period_end' => $subscription->current_period_end,
        ];
    }

    /**
     * [
     * [
     * 'course_id' => 313,
     * 'completed_lessons' => 5
     * ],
     * [
     * 'course_id' => 271,
     * 'completed_lessons' => 1
     * ]
     * ]
     * @param int $user_id
     * @return array
     */
    public static function getAllUserCourses(int $user_id): array
    {
        global $wpdb;

        $table = $wpdb->prefix . 'coursely_lesson_progress';

        return $wpdb->get_results(
            $wpdb->prepare(
                "
            SELECT 
                course_id,
                COUNT(*) as completed_lessons
            FROM {$table}
            WHERE user_id = %d
            AND status = 'completed'
            GROUP BY course_id
            ",
                $user_id
            ),
            ARRAY_A
        );
    }
    public static function getUserCompletedLessonsMap(int $user_id): array
    {
        $user_courses = self::getAllUserCourses($user_id);

        if (empty($user_courses)) {
            return [];
        }

        return array_column(
            $user_courses,
            'completed_lessons',
            'course_id'
        );
    }
}