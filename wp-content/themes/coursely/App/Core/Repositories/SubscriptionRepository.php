<?php

namespace coursely\App\Core\Repositories;

class SubscriptionRepository
{
    private string $table;

    public function __construct()
    {
        global $wpdb;

        $this->table = $wpdb->prefix . 'coursely_subscriptions';
    }

    public function getSubscriptionsEndingInDays(int $days): array
    {
        global $wpdb;

        return $wpdb->get_results(
            $wpdb->prepare("
                SELECT *
                FROM {$this->table}
                WHERE status = 'active'
                AND current_period_end IS NOT NULL
                AND DATE(current_period_end) = DATE(DATE_ADD(NOW(), INTERVAL %d DAY))
            ", $days)
        );
    }

    public function getExpiredSubscriptions(): array
    {
        global $wpdb;

        return $wpdb->get_results("
            SELECT *
            FROM {$this->table}
            WHERE status = 'active'
            AND current_period_end IS NOT NULL
            AND current_period_end < NOW()
        ");
    }

    public function updateStatus(int $id, string $status): void
    {
        global $wpdb;

        $wpdb->update(
            $this->table,
            ['status' => $status],
            ['id' => $id],
            ['%s'],
            ['%d']
        );
    }
}