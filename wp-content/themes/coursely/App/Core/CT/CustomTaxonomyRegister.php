<?php

namespace coursely\App\Core\CT;


class CustomTaxonomyRegister
{
	public function __construct()
	{
        add_action('init', [$this, 'register_custom_taxonomy']);
	}

	public function register_custom_taxonomy(): void
	{
		new CustomTaxonomy([
            'post_type'     => ['course'],
            'name'          => 'Course Category',
            'slug'          => 'course_category',
            'public'        => true,
            'hierarchical'  => true,
            'rewrite'       => [
                'slug' => 'course-category'
            ]
        ]);
	}

}
