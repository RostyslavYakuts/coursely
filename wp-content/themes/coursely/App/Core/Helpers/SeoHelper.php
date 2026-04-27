<?php

namespace coursely\App\Core\Helpers;

class SeoHelper
{
	public static function seo_title(): string
	{
		global $post;
		$title = ''; // Initialize a variable to hold the title
		if (get_query_var('virtual_search_page')) {
			$title .= 'Результати пошуку';
		}elseif (!defined('WPSEO_VERSION')) {
			if (is_404()) {
				$title .= '404 Page not found - ';
			} elseif ((is_single() || is_page()) && $post->post_parent) {
				$parent_title = get_the_title($post->post_parent);
				$title .= wp_title('-', true, 'right') . $parent_title . ' - ';
			} else {
				$title .= wp_title('-', true, 'right');
			}
			$blog_name = get_bloginfo('name') ?? '';
			$title .= $blog_name !== '' ? $blog_name : '.';
		} else {
			$wp_title = wp_title() ?: '';
			$title .= $wp_title ;
		}

		return $title;
	}
	public static function custom_canonical(): bool|array|string
	{
		global $paged;
		$str =  self::get_current_url();
		if($paged > 1 && is_home()) {
			$str = get_permalink( get_option( 'page_for_posts' ) );
		}
		if(strpos( $str, '?')){
			$str = substr($str, 0, strpos( $str, '?'));
		}
		return $str;
	}

	public static function get_current_url(): array|string
	{
		$pageURL = 'http';
		if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] === "on") {$pageURL .= "s";}
		$pageURL .= "://";
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		return str_replace('www.', '', $pageURL);
	}

	public static function get_site_property_google(): string {
		$site_property_google = 'qwerty';
		if ( get_field( 'site_property_google', 'options' ) ) {
			$site_property_google = get_field( 'site_property_google', 'options' );
		}

		return $site_property_google;
	}

}
