<?php

namespace coursely\App\Models;

use WP_Error;

abstract class CustomEntityModels
{
	abstract public static function get_entity_model(): array;

	/**
	 * Retrieves posts from a specific term in a taxonomy and post type, with an option to exclude certain post IDs.
	 *
	 * @param int|array $id The term ID or an array of term IDs to query.
	 * @param string $taxonomy The taxonomy to query.
	 * @param string $post_type The post type to query.
	 * @param array $exclude_posts Optional. An array of post IDs to exclude from the query. Default is an empty array.
	 * @param int $cache_duration Optional. Duration to cache the query in seconds. Default is 12 hours (43200 seconds).
	 * @return \WP_Query The query object containing the results.
	 * @throws \JsonException
	 */
	public static function get_current_term_posts(int|array $id, string $taxonomy, string $post_type, array $exclude_posts = [0], int $cache_duration = 3600): \WP_Query
	{
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		// Generate a unique cache key based on the query parameters
		try {
			// Generate a unique cache key based on the query parameters
			$transient_key = 'term_posts_' . md5(json_encode([$id, $taxonomy, $post_type, $exclude_posts, $paged], JSON_THROW_ON_ERROR));
		} catch (\JsonException $e) {
			// Handle the exception (log it, rethrow it, or return an empty query)
			error_log('Failed to generate transient key: ' . $e->getMessage());
			throw $e;
		}

		// Try to get the cached result
		$cached_query = get_transient($transient_key);

		// If a cached query exists, return it
		if ($cached_query !== false) {
			return $cached_query;
		}

		// If no cached query, create the query arguments
		$args = array(
			'posts_per_page' => 12,
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'post__not_in'   => $exclude_posts,
			'paged'          => $paged,
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => $taxonomy,
					'terms'    => $id,
					'field'    => 'term_id',
				),
			),
		);

		// Perform the query
		$query = new \WP_Query($args);

		// Cache the query result using a transient
		set_transient($transient_key, $query, $cache_duration);

		return $query;
	}

    /**
     * @param $taxonomy
     * @param null $exclude_id
     * @param bool $parent_only
     * @return array
     */
	public static function get_custom_terms($taxonomy, bool $parent_only = true, int $exclude_id = null): array
	{

		$args = [
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
		];

		if ($exclude_id) {
			$args['exclude'] = $exclude_id;
		}

        if ($parent_only) {
            $args['parent'] = 0;
        }

		$terms = get_terms($args);

		if( is_wp_error($terms) ){
			$err = new WP_Error('no_terms', 'No terms found', array('status' => 404));
			error_log($err->get_error_message());
			return [];
		}
		return $terms;
	}

	/**
	 * @param $id
	 * @param $taxonomy
	 * @return array
	 */
	public function generate_related_terms( $id, $taxonomy ): array {
		$terms = get_the_terms( $id, $taxonomy );
		$result = [];
		if ( $terms ) {
			foreach ( $terms as $key ) {
				$url = get_term_link( $key->term_id, $taxonomy );
				$result[] = [
					'id' => $key->term_id,
					'link' => $url,
					'name' => $key->name,
				];
			}
		}

		return $result;
	}

	/**
	 * Extracts the term IDs from an array of term data.
	 *
	 * Given an array of terms, each containing 'id', 'link', and 'name',
	 * this function returns an array containing only the 'id' values.
	 *
	 * @param array $terms An array of terms where each term is an associative array with keys 'id', 'link', and 'name'.
	 * @return array An array of integers representing the term IDs.
	 */
	public function get_related_products_terms_id( array $terms ): array
	{
		$ids = [];
		foreach( $terms as $term ) {
			$ids[] = $term['id'];
		}
		return $ids;
	}
}
