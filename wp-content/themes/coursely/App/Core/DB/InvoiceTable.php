<?php

namespace coursely\App\Core\DB;

class InvoiceTable
{
    private string $table;

    public function __construct()
    {
        global $wpdb;

        $this->table = $wpdb->prefix . 'coursely_invoices';
    }

    public function create(): void
    {
        global $wpdb;

        if ($this->exists()) {
            return;
        }

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "
            CREATE TABLE {$this->table} (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                user_id BIGINT UNSIGNED NOT NULL,
                stripe_invoice_id VARCHAR(255) NOT NULL,
                stripe_payment_intent_id VARCHAR(255) NULL,
                stripe_subscription_id VARCHAR(255) NULL,
                total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                currency VARCHAR(10) NOT NULL,
                status VARCHAR(50) NOT NULL,
                type VARCHAR(50) NULL,
                invoice_url TEXT NULL,
                hosted_invoice_url TEXT NULL,
                metadata LONGTEXT NULL,
                paid_at DATETIME NULL,
                refunded_at DATETIME NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                plan_name VARCHAR(100),
                plan_interval VARCHAR(20),

                PRIMARY KEY (id),

                UNIQUE KEY stripe_invoice_id (stripe_invoice_id),

                KEY user_id (user_id),
                KEY status (status),
                KEY stripe_subscription_id (stripe_subscription_id),
                KEY created_at (created_at)

            ) {$charsetCollate};
        ";

        dbDelta($sql);
    }

    private function exists(): bool
    {
        global $wpdb;

        $table = $wpdb->esc_like($this->table);

        $result = $wpdb->get_var(
            $wpdb->prepare(
                "SHOW TABLES LIKE %s",
                $table
            )
        );

        return $result === $this->table;
    }
}