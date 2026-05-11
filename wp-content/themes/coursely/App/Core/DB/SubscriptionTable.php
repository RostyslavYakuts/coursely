<?php

namespace coursely\App\Core\DB;

class SubscriptionTable extends CustomTable implements CustomTableInterface
{
    private string $table;

    public function __construct()
    {
        global $wpdb;

        $this->table = $wpdb->prefix . 'coursely_subscriptions';
    }

    public function create(): void
    {
        global $wpdb;

        if ($this->exists($this->table)) {
            return;
        }

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "
            CREATE TABLE {$this->table} (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                user_id BIGINT UNSIGNED NOT NULL,
                stripe_subscription_id VARCHAR(255) NOT NULL,
                stripe_customer_id VARCHAR(255) NOT NULL,
                stripe_price_id VARCHAR(255) NOT NULL,
                plan_name VARCHAR(100) NOT NULL,
                plan_interval VARCHAR(20) NOT NULL,
                status VARCHAR(50) NOT NULL,
                current_period_start DATETIME NULL,
                current_period_end DATETIME NULL,
                cancel_at_period_end TINYINT(1) DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                ended_at DATETIME NULL,

                PRIMARY KEY (id),

                UNIQUE KEY stripe_subscription_id (stripe_subscription_id),

                KEY user_id (user_id),
                KEY stripe_customer_id (stripe_customer_id),
                KEY status (status),
                KEY stripe_price_id (stripe_price_id),
                KEY current_period_end (current_period_end)

            ) {$charsetCollate};
        ";

        dbDelta($sql);
    }


}