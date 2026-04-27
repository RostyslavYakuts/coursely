<?php

namespace coursely\App\Core\Shortcodes;

class DateShortcodes
{
    public function register(): void
    {
        add_shortcode('current_date', [$this, 'date']);
        add_shortcode('current_year', [$this, 'year']);
    }

    public function date(): string
    {
        return date('F j, Y');
    }

    public function year(): string
    {
        return date('Y');
    }
}