<?php

namespace coursely\App\Core\Setup;

class StaticPagesInitializer
{
    const FLAG = 'mp_pages_initialized';

    private array $pages = [
        'Contact Us' => ['slug' => 'contact-us', 'template' => 'page-contact-us.php'],
    ];

    public function register(): void
    {
        add_action('init', [$this, 'init']);
    }

    public function init(): void
    {
        if (get_option(self::FLAG)) {
            return;
        }

        foreach ($this->pages as $title => $data) {
            $slug     = $data['slug'] ?? sanitize_title($title);
            $template = $data['template'] ?? null;
            $this->getOrCreatePage($title, $slug, $template);
        }


        update_option(self::FLAG, true);
    }

    private function getOrCreatePage(string $title, string $slug, ?string $template = null): void
    {
        $pages = get_posts([
            'post_type'      => 'page',
            'title'          => $title,
            'post_status'    => 'any',
            'posts_per_page' => 1,
        ]);

        if (!empty($pages)) {
            $page_id = $pages[0]->ID;
        } else {
            $page_id = wp_insert_post([
                'post_title'   => $title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_name'    => $slug,
            ]);
        }

        if ($template) {
            update_post_meta($page_id, '_wp_page_template', $template);
        }

    }

}