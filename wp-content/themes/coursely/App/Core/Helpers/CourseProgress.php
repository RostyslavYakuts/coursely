<?php

namespace coursely\App\Core\Helpers;

class CourseProgress
{
    public static function render($completed_lessons_count, $lessons_count):string
    {
        $completed_lessons_percentage = $lessons_count ? (int)round(($completed_lessons_count / $lessons_count) * 100) : 0;
        ob_start(); ?>
        <div class="completed-lessons-wrapper">
            <div class="completed-lessons w-full mt-8 flex justify-between items-center gap-3">
                <div class="flex items-center w-full text-sm font-medium">
             <span class="block text-brand-text ">
                <?php __('Completed lessons:','coursely'); ?>
            </span>&nbsp;
                    <span class="completed-lessons-count">
                <?php echo esc_html($completed_lessons_count); ?>
                </span>/
                    <span class="total-lessons-count">
                <?php echo esc_html($lessons_count); ?>
            </span>
                </div>
                <div class="w-full text-sm text-end font-medium">
             <span class="completed-lessons-percent">
                <?php echo esc_html($completed_lessons_percentage); ?>%
            </span>
                </div>
            </div>
            <div class="completed-lessons-progress-bar-wrapper mt-2.5 bg-gray w-full h-[6px]">
                <div style="width: <?php echo esc_html($completed_lessons_percentage); ?>%"  class="completed-lessons-progress-bar h-full bg-brand">

                </div>
            </div>
        </div>

    <?php
        return ob_get_clean();
    }
}