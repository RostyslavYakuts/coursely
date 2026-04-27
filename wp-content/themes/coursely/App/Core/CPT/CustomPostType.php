<?php

namespace coursely\App\Core\CPT;


class CustomPostType
{
    private $name;
    private $slug;
    private $icon;
    private $archive;
    private $public;
    private $supports;
    private $taxonomies;

    public function __construct(
      $name,$slug,$icon = 'dashicons-admin-page',
      $archive = false, $public = true,
      $supports = array( 'title', 'editor', 'thumbnail' ),
      $taxonomies = []) {
        $this->name = $name;
        $this->slug = $slug;
        $this->icon = $icon;
        $this->archive = $archive;
        $this->public = $public;
        $this->supports = $supports;
        $this->taxonomies = $taxonomies;
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
            'capability_type'       => 'page',
            'query_var'             => true,
            'menu_icon'             => $this->icon,
            'taxonomies'            => $this->taxonomies,
        );
    }
}
