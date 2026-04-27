<?php

namespace coursely\App\Core\Setup;

class HomePageInitializer
{
    const FLAG = 'mp_home_page_initialized';

    public function register(): void
    {
        add_action('init', [$this, 'init']);
    }

    public function init(): void
    {

        if (get_option(self::FLAG)) {
            return;
        }

        $page_id = $this->getOrCreateHomePage();

        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_id);

        update_option(self::FLAG, true);
    }

    private function getOrCreateHomePage(): int
    {
        $pages = get_posts([
            'post_type'      => 'page',
            'title'          => 'Home',
            'post_status'    => 'any',
            'posts_per_page' => 1,
        ]);

        if (!empty($pages)) {
            return $pages[0]->ID;
        }

        return wp_insert_post([
            'post_title'   => 'Home',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ]);
    }

}