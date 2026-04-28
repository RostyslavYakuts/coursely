<?php
/**
 * Class CustomTaxonomy
 */

namespace coursely\App\Core\CT;

class CustomTaxonomy
{
	private array|string $post_type;
	private string $name;
	private string $slug;
	private bool $public;
	private bool $hierarchical;
	private array $rewrite;

	/**
	 * @param $args
	 */
	public function __construct($args)
	{
		$this->post_type = $args['post_type'];
		$this->name = $args['name'];
		$this->slug = $args['slug'];
		$this->public = $args['public'];
		$this->hierarchical = $args['hierarchical'];
		if( isset($args['rewrite']) ) {
			$this->rewrite = $args['rewrite'];
		}
		else{
			$this->rewrite = [];
		}

		$this->registration();
	}

	public function registration(): void
	{
		if( !taxonomy_exists($this->slug) ){
			register_taxonomy(strtolower($this->slug), $this->post_type, $this->getDataArray());
		}

	}

	public function getDataArray(): array
	{
		$labelsArray = array(
			'name' => $this->name,
			'singular_name' => $this->name,
			'search_items' => 'Search ' . $this->name,
			'popular_items' => 'Popular ' . $this->name,
			'all_items' => 'All ' . $this->name . 's',
			'parent_item' => 'Parent ' . $this->name,
			'edit_item' => 'Edit ' . $this->name,
			'update_item' => 'Update ' . $this->name,
			'add_new_item' => 'Add New ' . $this->name,
			'new_item_name' => 'New ' . $this->name,
			'separate_items_with_commas' => 'Separate ' . $this->name . 's with commas',
			'add_or_remove_items' => 'Add or remove ' . $this->name . 's',
			'choose_from_most_used' => 'Choose from most used ' . $this->name . 's'
		);

		return array(
			'label' => $this->name,
			'labels' => $labelsArray,
			'public' => $this->public,
			'hierarchical' => $this->hierarchical,
			'show_in_rest' => true,
			'rest_base' => $this->slug,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'show_in_nav_menus' => true,
			'args' => array('orderby' => 'term_order'),
			'query_var' => true,
			'show_ui' => true,
			'rewrite' => $this->rewrite,
			'show_admin_column' => true,
		);

	}
}
