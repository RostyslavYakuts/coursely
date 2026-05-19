<?php

namespace coursely\App\Core\Cron;

abstract class AbstractCron
{
    protected string $hook;

    public function init(): void
    {
        add_action($this->hook, [$this, 'handle']);
    }

    public function schedule(): void
    {
        if (!wp_next_scheduled($this->hook)) {
            wp_schedule_event(time(), 'hourly', $this->hook);
        }
    }

    public function clear(): void
    {
        wp_clear_scheduled_hook($this->hook);
    }

    abstract public function handle(): void;
}