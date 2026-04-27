<?php

namespace coursely\App\Core\Setup;

class YoastInteractionSetup
{
	public function __construct(){
		$this->initialize();
	}

	public function initialize(): void
	{
		$this->remove_404_page_from_indexing();
		//add_filter('wpseo_canonical', '__return_false');
		add_filter('wpseo_title', [$this, 'rw_add_pagination_to_meta_title']);
		add_filter('wpseo_metadesc', [$this, 'rw_add_pagination_to_meta_description']);

		add_filter( 'wpseo_sitemap_entry', [$this,'exclude_empty_terms_from_sitemap'], 10, 3 );
		//add_filter( 'wpseo_sitemap_urlimages', array($this,'filter_wpseo_sitemap_urlimages'), 10, 2 );
		add_filter( 'wpseo_canonical', [$this,'custom_canonical_url_paginate'], 20, 1 );
		//add_filter( 'wpseo_canonical', array($this,'remove_trailing_slash_from_canonical'), 10, 2 );
		//add_filter( "wpseo_robots", array($this,'author_custom_robots'));
		//add_filter( "wpseo_robots", [$this,'search_page_robots']);
		add_filter('wpseo_remove_reply_to_com', '__return_false');
		add_filter( 'wpseo_opengraph_url', [$this,'open_graph_url_pagination']);
	}

	public function open_graph_url_pagination($url): string
	{
		if (  ! isset( $GLOBALS['wp'] ) || is_admin() ) {
			return (string)$url;
		}

		if ( is_paged() ) {
			global $wp;
			$current_url = home_url( trailingslashit( add_query_arg( [], $wp->request ) ) );
			return $current_url ?: $url;
		}

		return (string)$url;
	}
	public function search_page_robots ( $string ): string
	{
		if (get_query_var('virtual_search_page')) {
			return "noindex, nofollow";
		}
		return $string;
	}
	public function author_custom_robots ( $string ): string {
		if ( is_author() ) {
			return "index, follow";
		}
		return $string;
	}
	public function remove_trailing_slash_from_canonical($canonical_url, $post) {
		if (!empty($canonical_url) && substr($canonical_url, -1) === '/') {
			$canonical_url = rtrim($canonical_url, '/');
		}

		return $canonical_url;
	}


	public function custom_canonical_url_paginate( $canonical_url ) {
		$blog_page_id = get_option( 'page_for_posts' );

		if ( $blog_page_id ) {
			$paged = max( 1, get_query_var( 'paged' ) );

			if ( $paged > 1 ) {
				$blog_page_url = get_permalink( $blog_page_id );

				if ( $blog_page_url ) {
					return trailingslashit( $blog_page_url );
				}
			}
		}
		if (!is_tax() ) {
			return $canonical_url;
		}
		if (is_tax('theme')) {
			$term = get_queried_object();
			$term_id = $term->term_id;
			return get_term_link($term_id, 'theme');
		}

		if (is_category()) {
			$term = get_queried_object();
			$term_id = $term->term_id;
			return get_term_link($term_id, 'category');
		}

		if (is_tax('product_tag')) {
			$term = get_queried_object();
			$term_id = $term->term_id;
			return get_term_link($term_id, 'product_tag');
		}

		if(is_tax('post_tag')) {
			$term = get_queried_object();
			$term_id = $term->term_id;
			return get_term_link($term_id, 'post_tag');
		}

		return $canonical_url;
	}

	/**
	 * Add noindex, nofollow to robots meta tag on 404
	 *
	 * @return void
	 */
	protected function remove_404_page_from_indexing(): void {
		add_filter( "wpseo_robots", function ( $string ): string {
			if ( is_404() ) {
				return "noindex, nofollow";
			}

			return $string;
		} );
	}
	public function rw_add_pagination_to_meta_title($title)
	{
		if (is_category() && is_paged()) {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			if ($paged && $paged > 1) {
				$title .= ' - Page ' . $paged;
			}
		}
		return $title;
	}

	public function rw_add_pagination_to_meta_description($meta_description)
	{
		if (is_category() && is_paged()) {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			if ($paged && $paged > 1) {
				$meta_description .= ' - Page ' . $paged;
			}
		}

		return $meta_description;
	}

	public function exclude_empty_terms_from_sitemap( $url, $type, $object_id): array
	{
		if ($type === 'term') {
			$term = get_term($object_id);
			if (empty($term->description)) {
				return [];
			}
		}

		return $url;
	}
}
