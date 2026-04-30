<?php

namespace coursely\App\Core\Helpers;

class CourseCard
{
    public static function render(array $course): string
    {
        ob_start();
        ?>

        <a href="<?= esc_html($course['link']) ?>" class="course-card brand-shadow flex flex-col gap-5 rounded-[20px]">
            <div class="course-thumbnail relative">
                <span class="min-w-[80px] text-center absolute top-2 left-2 z-10 rounded-full bg-white text-brand-dark text-sm px-2.5 py-2"><?= esc_html($course['category']) ?></span>
                <img loading="lazy" decoding="async"
                     src="<?= esc_html($course['thumbnail']) ?>"
                     alt="<?= esc_html($course['title']) ?>"
                     width="427" height="257" class="rounded-[20px] w-full h-auto object-contain">
            </div>
            <div class="course-info px-6 flex flex-col gap-4 pb-[32px]">
                <div class="course-statistic flex justify-between items-center">
                    <span class="flex items-center gap-2 text-brand-text">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_241_1399)">
                        <circle cx="8" cy="8" r="7.25" stroke="#667085" stroke-width="1.5"/>
                        <path d="M8 4.44446V8.56799L10.6667 9.77779" stroke="#667085" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_241_1399">
                        <rect width="16" height="16" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                        <?= esc_html($course['duration']) ?>
                    </span>
                    <span class="flex items-center gap-2 text-brand-text">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="8" cy="8" r="7.25" stroke="#667085" stroke-width="1.5"/>
                        <path d="M7 6V10L10.5 8L7 6Z" fill="#667085" stroke="#667085" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?= esc_html($course['lessons_count']) ?> <?= esc_html(__('lessons','coursely')) ?>
                    </span>
                    <span class="flex items-center gap-2 text-brand-text">
                        <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.03795 14.0193C8.35574 13.8275 8.75363 13.8275 9.07142 14.0193L12.7057 16.2128C13.463 16.6698 14.3972 15.9909 14.1963 15.1294L13.2318 10.9952C13.1475 10.6337 13.2703 10.2552 13.5509 10.0122L16.7633 7.22927C17.4319 6.65006 17.0745 5.5518 16.1931 5.47702L11.9656 5.11836C11.596 5.087 11.2741 4.85366 11.1294 4.51216L9.47541 0.609749C9.13082 -0.203279 7.97856 -0.203281 7.63397 0.609747L5.98 4.51216C5.83527 4.85366 5.5134 5.087 5.14382 5.11836L0.916316 5.47702C0.0348899 5.5518 -0.322516 6.65006 0.346082 7.22926L3.55848 10.0122C3.83905 10.2552 3.96189 10.6337 3.87756 10.9952L2.9131 15.1294C2.71214 15.9909 3.64637 16.6698 4.40369 16.2128L8.03795 14.0193Z" fill="#FFB608"/>
                        </svg>
                        (<?= esc_html($course['rating']) ?>)
                    </span>
                </div>
                <h3 class="text-brand-dark text-lg lgx:text-xl font-medium"><?= esc_html($course['title']) ?></h3>
                <p class="text-brand-text lgx:text-lg">
                    <?= esc_html($course['excerpt']) ?>
                </p>
                <button type="button" class="w-full rounded-full border border-gray text-center p-4 text-lg text-brand-dark">
                    <?= esc_html(__('View Course','coursely')) ?>
                </button>
            </div>
        </a>

        <?php
        return ob_get_clean();
    }
}