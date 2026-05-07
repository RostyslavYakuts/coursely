<?php
namespace coursely\App\Core\CPT;

class CPTSlugRewrite
{
    private string $postType;
    private string $baseSlug;

    public function __construct(string $postType, string $baseSlug)
    {
        $this->postType = $postType;
        $this->baseSlug = trim($baseSlug, '/');

        add_filter('post_type_link', [$this, 'filterPostTypeLink'], 10, 2);
        add_action('init', [$this, 'addRewriteRules']);
    }

    /**
     * Generate custom URL:
     * /courses/lesson-title
     */
    public function filterPostTypeLink($link, $post)
    {
        if ($post->post_type !== $this->postType || $post->post_status !== 'publish') {
            return $link;
        }

        return home_url('/' . $this->baseSlug . '/' . $post->post_name . '/');
    }

    /**
     * Register rewrite rule:
     * /courses/{slug} → post_type
     */
    public function addRewriteRules(): void
    {
        add_rewrite_rule(
            '^' . $this->baseSlug . '/([^/]+)/?$',
            'index.php?post_type=' . $this->postType . '&name=$matches[1]',
            'top'
        );
    }
}