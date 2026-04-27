<?php

namespace coursely\App\Core\Setup;
class CommentsSetup
{

	public function initialize(): void
	{
		add_action('wp_before_admin_bar_render', [$this, 'mp_admin_bar_render']);
		add_action('admin_menu', [$this, 'remove_comments_from_admin_menus']);
		add_action('init', [$this, 'remove_comment_support'],100);

	}
	public function mp_admin_bar_render(): void
	{
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
	}
	public function remove_comments_from_admin_menus(): void
	{
		remove_menu_page('edit-comments.php');
	}
	public function remove_comment_support(): void
	{
		remove_post_type_support('post', 'comments');
		remove_post_type_support('page', 'comments');
	}

}
