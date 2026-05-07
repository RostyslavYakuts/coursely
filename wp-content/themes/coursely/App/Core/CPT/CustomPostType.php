<?php

namespace coursely\App\Core\CPT;


class CustomPostType
{
    private string $name;
    private string $slug;
    private mixed $icon;
    private mixed $archive;
    private mixed $public;
    private mixed $supports;
    private mixed $taxonomies;
    private mixed $exclude_from_search;

    public function __construct(
      $name,$slug,$icon = 'dashicons-admin-page',
      $archive = false, $public = true,
      $supports = array( 'title', 'editor', 'thumbnail' ),
      $taxonomies = [],$exclude_from_search = false) {
        $this->name = $name;
        $this->slug = $slug;
        $this->icon = $icon;
        $this->archive = $archive;
        $this->public = $public;
        $this->supports = $supports;
        $this->taxonomies = $taxonomies;
        $this->exclude_from_search = $exclude_from_search;
        $this->registration();
    }

    protected function registration(): void{
        register_post_type( strtolower($this->slug),$this->dataArray());
    }

    protected function dataArray(): array{
        $labelsArray = array(
            'name' => $this->name,
            'singular_name' => $this->name,
            'menu_name' => $this->name
        );
        return array(
            'labels'                => $labelsArray,
            'public'                => $this->public,
            'show_ui'               => true,
            'show_in_rest'          => true,
            'show_in_menu'          => true,
            'supports'              => $this->supports,
            'rewrite'               => array( 'slug' => $this->slug ),
            'has_archive'           => $this->archive,
            'hierarchical'          => true,
            'show_in_nav_menus'     => true,
            'exclude_from_search'   => $this->exclude_from_search,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'query_var'             => true,
            'menu_icon'             => $this->icon,
            'taxonomies'            => $this->taxonomies,
        );
    }
}
