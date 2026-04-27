<?php
namespace coursely\App\Core\CPT;

class CPTSlugRewrite
{
    private string $cpt_slug;
    public function __construct(string $slug)
    {
        $this->cpt_slug = $slug;
        add_filter('post_type_link', [$this, 'remove_slug'], 10, 3);
        add_action('template_redirect', [$this, 'cpt_slug_redirect']);
    }
    public function remove_slug($post_link, $post)
    {
        if ($this->cpt_slug !== $post->post_type || 'publish' !== $post->post_status) {
            return $post_link;
        }

        return str_replace('/' . $post->post_type . '/', '/', $post_link);
    }
    public function cpt_slug_redirect(): void
    {
        global $wp_query;

        if (!isset($wp_query->query['name'])) {
            return;
        }

        $post = get_page_by_path($wp_query->query['name'], OBJECT, $this->cpt_slug);
        if ($post) {
            $wp_query->query_vars['post_type'] = $this->cpt_slug;
            $wp_query->is_single = true;
            $wp_query->is_page = false;
            $wp_query->is_singular = true;
        }
    }

}