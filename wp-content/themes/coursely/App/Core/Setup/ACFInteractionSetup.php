<?php

namespace coursely\App\Core\Setup;

class ACFInteractionSetup
{

	/**
	 * @param $path
	 * @return string
	 */
	public function my_acf_json_save_point($path): string
	{
		// update path
		$path = get_stylesheet_directory() . '/acf';
		// return
		return $path;
	}


	public function my_acf_json_load_point($paths)
	{
		// remove original path (optional)
		unset($paths[0]);
		// append path
		$paths[] = get_stylesheet_directory() . '/acf';
		// return
		return $paths;
	}

	/**
	 * Creates ACF Theme General Settings page in Admin
	 * @return void
	 */
	public function acf_options_setup(): void
	{
		if (function_exists('acf_add_options_page')) {
			acf_add_options_page(array(
				'page_title' => 'Theme General Settings',
				'menu_title' => 'Theme Settings',
				'menu_slug' => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect' => false
			));
		}
	}
	public function enable_shortcodes_in_acf_text($value, $post_id, $field): string
	{
		return do_shortcode($value);
	}

	public function initialize(): void
	{
		$this->acf_options_setup();
		add_filter('acf/settings/save_json', array($this, 'my_acf_json_save_point'));
		add_filter('acf/settings/load_json', array($this, 'my_acf_json_load_point'));
		add_filter('acf/settings/remove_wp_meta_box', '__return_false', 9999);
		//add_filter('acf/format_value/type=text', array($this,'enable_shortcodes_in_acf_text', 10, 3));
		//add_filter('acf/settings/show_admin', '__return_false');
	}
}
