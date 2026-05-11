<?php

namespace coursely\App\Core\Services;

class CourseProgressService
{
    private static array $cache = [];

    public static function getCompletedLessons(int $user_id, int $course_id):array{
        $cache_key = 'completed_lessons_' .
            $user_id . '_' . $course_id;

        if (isset(self::$cache[$cache_key])) {
            return self::$cache[$cache_key];
        }

        global $wpdb;

        $table = $wpdb->prefix . 'coursely_lesson_progress';

        $lessons = $wpdb->get_col(
            $wpdb->prepare(
                "
            SELECT lesson_id
            FROM {$table}
            WHERE user_id = %d
            AND course_id = %d
            AND status = %s
            ",
                $user_id,
                $course_id,
                'completed'
            )
        );

        $lessons = array_map('intval', $lessons);

        self::$cache[$cache_key] = $lessons;

        return $lessons;
    }
}