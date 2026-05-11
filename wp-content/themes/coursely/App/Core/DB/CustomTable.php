<?php

namespace coursely\App\Core\DB;

class CustomTable
{
    protected function exists($tbl): bool
    {
        global $wpdb;

        $table = $wpdb->esc_like($tbl);

        $result = $wpdb->get_var(
            $wpdb->prepare(
                "SHOW TABLES LIKE %s",
                $table
            )
        );

        return $result === $tbl;
    }
}