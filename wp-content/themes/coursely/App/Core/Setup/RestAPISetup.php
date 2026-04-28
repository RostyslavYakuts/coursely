<?php

namespace coursely\App\Core\Setup;

use coursely\App\Core\Helpers\CourseCard;

class RestAPISetup
{

	public function __construct()
	{
		remove_action('template_redirect', 'rest_output_link_header', 11);
		add_filter('rest_endpoints', [$this,'hide_users_endpoint']);
		add_action('rest_api_init', array($this, 'register_load_more_posts'));
        add_action('rest_api_init', array($this, 'register_load_more_tax_posts'));

        add_action('rest_api_init', [$this,'register_course_filter']);

	}

    public function register_course_filter(): void
    {
        register_rest_route(
            'courses/v1',
            '/filter',
            [
                'methods' => 'GET',
                'callback' => [$this,'filter_courses'],
                'permission_callback' => '__return_true',
            ]
        );
    }

    public function filter_courses(\WP_REST_Request $request): \WP_REST_Response{
        $html = '';
        $courses = [];
        if($request->get_param('term_id') !== 'all'){

            $term_id = (int) $request->get_param('term_id');

            $args = [
                'post_type' => 'course',
                'posts_per_page' => -1,
                'meta_key' => 'rating',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            ];


            if ($term_id) {

                $args['tax_query'] = [
                    [
                        'taxonomy' => 'course_category',
                        'field' => 'term_id',
                        'terms' => $term_id,
                        'include_children' => true
                    ]
                ];
            }

            $query = new \WP_Query($args);

            while ($query->have_posts()) {

                $query->the_post();
                $id = get_the_ID();
                $rating = get_field('rating',$id);
                $duration = get_field('duration',$id);
                $lessons_count = get_field('lessons_count',$id);

                $terms = get_the_terms(
                    $id,
                    'course_category'
                );

                $parent_category = '';

                if ($terms) {
                    foreach ($terms as $term) {

                        if ($term->parent) {
                            $parent = get_term($term->parent);
                            $parent_category = $parent->name;
                            break;
                        }

                        $parent_category = $term->name;
                    }
                }
                $courses[] = [
                    'id' => $id,
                    'title' => get_the_title($id),
                    'excerpt' => get_the_excerpt($id),
                    'link' => get_permalink($id),
                    'thumbnail' => get_the_post_thumbnail_url($id, 'medium_large'),
                    'rating' => $rating,
                    'duration' => $duration,
                    'lessons_count' => $lessons_count,
                    'category' => $parent_category
                ];

            }
            foreach( $courses as $course){
                $html .= CourseCard::render($course);
            }

            wp_reset_postdata();
        }else{
            $query = new \WP_Query([
                'post_type'      => 'course',
                'posts_per_page' => 3,
                'meta_key'       => 'rating',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC'
            ]);

            if ($query->have_posts()) {

                foreach ($query->posts as $post) {

                    $terms = get_the_terms(
                        $post->ID,
                        'course_category'
                    );

                    $parent_category = '';

                    if ($terms && !is_wp_error($terms)) {

                        foreach ($terms as $term) {

                            // parent category
                            if ($term->parent) {

                                $parent = get_term($term->parent);

                                if ($parent && !is_wp_error($parent)) {
                                    $parent_category = $parent->name;
                                    break;
                                }
                            }

                            // fallback
                            if (!$term->parent) {
                                $parent_category = $term->name;
                            }
                        }
                    }

                    $courses[] = [
                        'id' => $post->ID,
                        'title' => get_the_title($post->ID),
                        'excerpt' => get_the_excerpt($post->ID),
                        'link' => get_permalink($post->ID),
                        'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium_large'),
                        'rating' => get_field('rating', $post->ID),
                        'duration' => get_field('duration', $post->ID),
                        'lessons_count' => get_field('lessons_count', $post->ID),
                        'category' => $parent_category
                    ];
                }
                foreach ($courses as $course) {
                    $html .= CourseCard::render($course);
                }
            }

            wp_reset_postdata();

        }


        return new \WP_REST_Response([
            'html' => $html
        ]);
    }





















    public function register_load_more_posts(): void
    {
        register_rest_route('blog/v1', '/posts', array(
            'methods' => 'GET',
            'callback' => [$this,'handle_load_more_posts'],
            'permission_callback' => '__return_true',
        ));
    }
    public function handle_load_more_posts(\WP_REST_Request $request): \WP_REST_Response
    {
        $page    = max(1, (int) $request->get_param('page'));

        $html = '';
        $query = new \WP_Query([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 6,
            'paged'          => $page,
        ]);

        if (!$query->have_posts()) {
            return new \WP_REST_Response([
                'html' => '',
                'max_pages' => $query->max_num_pages,
            ]);
        }

        while ($query->have_posts()) {
            $query->the_post();
            $html .= '<article class="group rounded-xl overflow-hidden hover:shadow-lg transition">

                    <a href="'.get_permalink().'" class="block">
                        <div class="aspect-[4/3] overflow-hidden">'.
                            get_the_post_thumbnail(
                                get_the_ID(),
                                'medium_large',
                                ['class'=>'w-full h-full object-cover group-hover:scale-105 transition']
                            ) .'
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold line-clamp-2 group-hover:text-brand transition">
                                '.get_the_title().'
                            </h3>

                            <span class="text-sm text-gray-500 block mt-2">
                            '.get_the_date().'
                        </span>
                        </div>
                    </a>

                </article>';
        }

        wp_reset_postdata();

        return new \WP_REST_Response([
            'html' => $html,
            'max_pages' => $query->max_num_pages,
        ]);
    }

    public function register_load_more_tax_posts(): void
    {
        register_rest_route('custom/v1/', '/posts', array(
            'methods' => 'GET',
            'callback' => [$this,'handle_load_more_tax_posts'],
            'permission_callback' => '__return_true',
        ));
    }

    public function handle_load_more_tax_posts(\WP_REST_Request $request): \WP_REST_Response
    {
        $page    = max(1, (int) $request->get_param('page'));
        $term_id = (int) $request->get_param('term_id');
        $term = get_term($term_id);

        if (is_wp_error($term) || !$term) {
            return new \WP_REST_Response([
                'html' => '',
                'has_more' => false,
            ]);
        }
        $taxonomy = $term->taxonomy;

        $html = '';
        $query = new \WP_Query([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 6,
            'paged'          => $page,
            'tax_query'      => [
                [
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                    'include_children' => is_taxonomy_hierarchical($term->taxonomy),
                ],
            ],
        ]);

        if (!$query->have_posts()) {
            return new \WP_REST_Response([
                'html' => '',
                'max_pages' => $query->max_num_pages,
            ]);
        }

        while ($query->have_posts()) {
            $query->the_post();
            $post_id   = get_the_ID();
            $title     = get_the_title($post_id);
            $link      = get_permalink($post_id);
            $image     = get_the_post_thumbnail_url($post_id,'medium');
            $date      = get_the_date('F d, Y', $post_id);
            $excerpt   = get_the_excerpt($post_id);
            $html .= '<a href="'.$link.'"
                       class="group border border-gray-200 hover:border-brand
                              rounded-2xl w-full h-full p-4
                              flex flex-col justify-between
                              bg-white shadow-sm hover:shadow-xl
                              transition duration-500">
                        <div class="overflow-hidden rounded-xl mb-4">
                            <img width="300" height="300"
                                 loading="lazy"
                                 decoding="async"
                                 src="'.$image.'"
                                 alt="'.$title.'"
                                 class="w-full h-[220px] object-cover
                                        transition duration-700
                                        group-hover:scale-105">
                        </div>
                        <h3 title="'.$title.'"
                            class="text-gray-900 group-hover:text-brand
                                   text-lg font-semibold text-center
                                   line-clamp-3 min-h-[72px]
                                   transition-colors">
                            '.$title.'
                        </h3>
                        <div class="text-sm text-gray-500 flex flex-col items-center gap-1 mt-2">
                            <span>'.$date.'</span>
                        </div>
                        <p class="text-sm text-gray-600 text-center line-clamp-2 mt-3">
                            '.$excerpt.'
                        </p>
                        <span class="mt-5 text-center uppercase tracking-wider
                                     bg-brand hover:bg-brand-hover
                                     text-white py-3 rounded
                                     transition">
                           '.__('Learn more','ws').'
                        </span>

                    </a>';
        }

        wp_reset_postdata();

        return new \WP_REST_Response([
            'html' => $html,
            'max_pages' => $query->max_num_pages,
        ]);
    }
	public function hide_users_endpoint($endpoints)
	{
		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		return $endpoints;

	}
}
