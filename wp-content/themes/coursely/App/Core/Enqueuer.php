<?php

namespace coursely\App\Core;
class Enqueuer
{
	public function __construct()
	{
		$this->initialize();
	}

	public function initialize(): void
	{
		add_action('wp_enqueue_scripts', array($this, 'enqueue_files'));
		add_action('wp_default_scripts', array($this, 'remove_jquery_migrate'));
		add_action('wp_enqueue_scripts', array($this, 'remove_global_styles'));
		add_action('wp_enqueue_scripts', array($this, 'mp_ajax_localize_vars'));
		add_action('wp_enqueue_scripts', array($this, 'deregister_scripts_styles'));
		add_action('widgets_init', array($this, 'remove_recent_comments_style'));
		//add_filter('style_loader_src', array($this, 'remove_wp_ver_css_js'));
		//add_filter('script_loader_src', array($this, 'remove_wp_ver_css_js'));
		add_action('wp_enqueue_scripts', array($this,'dequeue_block_library_style'));
		if (!is_admin()) {
			add_filter('script_loader_tag', array($this, 'clean_script_tag'));
		}
       // add_filter('style_loader_tag', [$this,'async_styles'],10,3);

	}
    public function async_styles($html,$handle,$href)
    {
        if (preg_match('/href=[\'"]([^\'"]+)[\'"]/', $html, $matches)) {
            $href = $matches[1];
            $filename = basename($href);

            if (!str_contains($filename, 'main')) {
                return "<link rel='preload' href='{$href}' as='style' onload=\"this.onload=null;this.rel='stylesheet'\">";
            }
        }

        return $html;
    }

	public function remove_recent_comments_style(): void
	{
		global $wp_widget_factory;
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
	public function dequeue_block_library_style(): void
	{
		wp_dequeue_style('wp-block-library');
	}



	// Remove wp version param from any enqueued scripts except admin
	public function remove_wp_ver_css_js($src)
	{
		if (is_admin()) {
			return $src;
		}
		if (strpos($src, 'ver=')) {
			$src = remove_query_arg('ver', $src);
		}
		return $src;
	}

    public function clean_script_tag($tag)
    {
        if (str_contains($tag, 'wp-polyfill-fetch')) {
            return $tag;
        }

        return str_replace(" type='text/javascript'", '', $tag);
    }


	public function enqueue_files(): void
	{
		$dirJS = new \DirectoryIterator(get_stylesheet_directory() . '/assets/dist');
		foreach ($dirJS as $file) {

			if (pathinfo($file, PATHINFO_EXTENSION) === 'js') {
				$fullName = basename($file);
				$name = substr(basename($fullName), 0, strpos(basename($fullName), '.'));
				$js_version = date( 'ymd-Gis', filemtime( get_template_directory() . '/assets/dist/' . $fullName ) );
                if (str_contains($fullName, 'home')) {
                    if (is_front_page()) {
                        wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/' . $fullName, [], $js_version,  ['in_footer' => true, 'strategy'  => 'defer']);
                    }
                    continue;
                }
                if (str_contains($fullName, 'contacts')) {
                    $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
                    if ($template === 'page-contact-us.php') {
                        wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/' . $fullName, [], $js_version,  ['in_footer' => true, 'strategy'  => 'defer']);
                    }
                    continue;
                }
                if (str_contains($fullName, 'courses')) {
                    $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
                    if ($template === 'page-courses.php') {
                        wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/' . $fullName, [], $js_version,  ['in_footer' => true, 'strategy'  => 'defer']);
                    }
                    continue;
                }
                if (str_contains($fullName, 'pricing')) {
                    $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
                    if ($template === 'page-pricing.php') {
                        wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/' . $fullName, [], $js_version,  ['in_footer' => true, 'strategy'  => 'defer']);
                    }
                    continue;
                }
                if (str_contains($fullName, 'blog')) {
                    $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
                    if ($template === 'page-blog.php') {
                        wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/' . $fullName, [], $js_version,  ['in_footer' => true, 'strategy'  => 'defer']);
                    }
                    continue;
                }
                if (str_contains($fullName, 'post')) {
                    if (is_singular('post') || is_singular('service')) {
                        wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/' . $fullName, [], $js_version,  ['in_footer' => true, 'strategy'  => 'defer']);
                    }
                    continue;
                }
                if (str_contains($fullName, 'taxonomy')) {
                    if (is_category() || is_tag()) {
                        wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/' . $fullName, [], $js_version,  ['in_footer' => true, 'strategy'  => 'defer']);
                    }
                    continue;
                }

				wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/' . $fullName, [], $js_version,
                    ['in_footer' => true, 'strategy'  => 'defer']
                );
			}
			if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {

				$fullName = basename($file);
                $handle = 'css-' . md5($fullName);
				$css_version = date( 'ymd-Gis', filemtime( get_template_directory() . '/assets/dist/' . $fullName ) );
                if (str_contains($fullName, 'home')) {
                    if(is_front_page()){
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . '/assets/dist/' . $fullName,
                            [],
                            filemtime(get_template_directory() . '/assets/dist/' . $fullName)
                        );
                    }
                    continue;
                }
                if (str_contains($fullName, 'post')) {
                    if(is_singular('post')){
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . '/assets/dist/' . $fullName,
                            [],
                            filemtime(get_template_directory() . '/assets/dist/' . $fullName)
                        );
                    }
                    continue;
                }
                if (str_contains($fullName, 'taxonomy')) {
                    if(is_category() || is_tag()){
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . '/assets/dist/' . $fullName,
                            [],
                            filemtime(get_template_directory() . '/assets/dist/' . $fullName)
                        );
                    }
                    continue;
                }
                if (str_contains($fullName, 'contacts')) {
                    $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
                    if ($template === 'page-contact-us.php') {
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . '/assets/dist/' . $fullName,
                            [],
                            filemtime(get_template_directory() . '/assets/dist/' . $fullName)
                        );
                    }
                    continue;
                }
                if (str_contains($fullName, 'courses')) {
                    $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
                    if ($template === 'page-courses.php') {
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . '/assets/dist/' . $fullName,
                            [],
                            filemtime(get_template_directory() . '/assets/dist/' . $fullName)
                        );
                    }
                    continue;
                }
                if (str_contains($fullName, 'pricing')) {
                    $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
                    if ($template === 'page-pricing.php') {
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . '/assets/dist/' . $fullName,
                            [],
                            filemtime(get_template_directory() . '/assets/dist/' . $fullName)
                        );
                    }
                    continue;
                }
                if (str_contains($fullName, 'blog')) {
                    $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
                    if ($template === 'page-blog.php') {
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . '/assets/dist/' . $fullName,
                            [],
                            filemtime(get_template_directory() . '/assets/dist/' . $fullName)
                        );
                    }
                    continue;
                }

                wp_enqueue_style(
                    $handle,
                    get_template_directory_uri() . '/assets/dist/' . $fullName,
                    [],
                    $css_version);
			}

		}

	}


	// Remove jquery migrate
	public function remove_jquery_migrate($scripts): void
	{
		if (isset($scripts->registered['jquery'])) {
			$script = $scripts->registered['jquery'];

			if ($script->deps) {
				$script->deps = array_diff($script->deps, array('jquery-migrate'));
			}
		}
	}


	public function deregister_scripts_styles(): void
	{
		wp_dequeue_style('thickbox');
		if (!is_admin() && !is_user_logged_in()) {
            wp_deregister_script('jquery');
			wp_deregister_script('wp-embed');
			wp_deregister_style('dashicons');
		}

	}


	/**
	 * Remove inline style wp
	 */

	public function remove_global_styles(): void
	{
		wp_dequeue_style('global-styles');
	}


	public function mp_ajax_localize_vars(): void
	{
		wp_localize_script('main', 'localizedScript', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'pk' =>  get_field('recaptcha_public_key', 'options'),
                'login_form_action'=>'login_form_action',
                'login_form_nonce'=> wp_create_nonce('login_form_action'),
                'contact_us_form_action' => 'contact_us_form_action',
                'contact_us_form_nonce' => wp_create_nonce('contact_us_form_action'),
			)
		);

	}


}
