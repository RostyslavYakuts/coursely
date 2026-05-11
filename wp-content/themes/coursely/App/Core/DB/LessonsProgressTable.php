<?php

namespace coursely\App\Core\DB;

class LessonsProgressTable extends CustomTable implements CustomTableInterface
{
    private string $table;

    public function __construct()
    {
        global $wpdb;

        $this->table = $wpdb->prefix . 'coursely_lesson_progress';
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
                 course_id BIGINT UNSIGNED NOT NULL,
                 lesson_id BIGINT UNSIGNED NOT NULL,
                 status VARCHAR(30) NOT NULL DEFAULT 'not_started',
                 quiz_score INT NULL,
                 completed_at DATETIME NULL,
                 updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                 ON UPDATE CURRENT_TIMESTAMP,
                 PRIMARY KEY (id),
                UNIQUE KEY user_lesson (
                    user_id,
                    lesson_id
                ),
                KEY user_id (user_id),
                KEY course_id (course_id),
                KEY lesson_id (lesson_id),
                KEY status (status)
            ) {$charsetCollate};
        ";

        dbDelta($sql);
    }


}