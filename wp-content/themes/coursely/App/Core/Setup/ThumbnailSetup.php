<?php

namespace coursely\App\Core\Setup;

class ThumbnailSetup
{

	public function initialize(): void
	{
		$this->set_theme_support();
		//$this->set_image_sizes();
		add_filter('upload_mimes', [$this,'custom_mime_types']);
		//add_action( 'wp', [$this, 'attachment_redirect']);
	}

	public function set_image_sizes(): void
	{
		add_image_size( 'free', '1920', '', true );
		add_image_size( '180x80', '180', '80', true );
		add_image_size( '332_221', '332', '221', true );
		add_image_size( 'spec_thumb', 260, 140, true );
		add_image_size( 'clients', 300, 300, true );
		add_image_size( 'custom-size', 220, 220, array( 'left', 'top' ) );
	}

	public function set_theme_support(): void
	{
		add_theme_support('post-thumbnails');
		//add_theme_support('title-tag');
		add_theme_support('html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',));
	}
	public function custom_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	public function attachment_redirect($wp): void
	{
		if (is_attachment()) {
			$location = get_home_url() . '/attach';
			wp_redirect( $location );
			exit;
		}
	}

}
