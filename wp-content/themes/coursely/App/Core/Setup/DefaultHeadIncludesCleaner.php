<?php
namespace coursely\App\Core\Setup;
class DefaultHeadIncludesCleaner
{
	public function no_index_follow_admin(): void
	{
		if (is_admin()) { ?>
			<meta name="robots" content="noindex, nofollow"/>
		<?php }
	}
	//remove ID and classes in menu list
	public function wp_IEhtml5_js(): void
	{
		global $is_IE;
		if ($is_IE)
			echo '<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]--><!--[if lte IE 9]><link href="' . theme() . '/style/animations-ie-fix.css" rel="stylesheet" /><![endif]-->';
	}
	/**
	 * Remove api.w.org from resource hints (preconnect/preload) if present.
	 */
	public function filter_resource_hints(array $urls, $relation_type): array
	{
		foreach ($urls as $i => $url) {
			if (str_contains((string)$url, 'api.w.org')) {
				unset($urls[$i]);
			}
		}
		return $urls;
	}

	public function initialize(): void
	{
		remove_action('wp_head', 'rest_output_link_wp_head', 10);
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'parent_post_rel_link', 10);
		remove_action('wp_head', 'start_post_rel_link', 10);
		remove_action('wp_head', 'wp_shortlink_wp_head');
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'rel_canonical');
		remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_head', 'wp_oembed_add_host_js');
		remove_action('wp_print_styles', 'print_emoji_styles');

		add_filter('xmlrpc_enabled', '__return_false');
		add_filter('rest_output_link', '__return_false');
		add_filter('wp_resource_hints', [$this, 'filter_resource_hints'], 10, 2);

		add_action('wp_head', array($this, 'wp_IEhtml5_js'));
		add_action('admin_head', array($this, 'no_index_follow_admin'));
	}
}
