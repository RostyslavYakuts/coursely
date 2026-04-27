<?php

namespace coursely\App\Core\Setup;

class PermalinkInitializer
{
    public function register(): void
    {
        add_action('init', [$this, 'setPostNamePermalinks']);
    }

    public function setPostNamePermalinks(): void
    {

        $current_structure = get_option('permalink_structure');

        if ($current_structure === '/%postname%/') {
            return;
        }

        update_option('permalink_structure', '/%postname%/');

        flush_rewrite_rules();
    }

}