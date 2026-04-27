<?php

namespace coursely\App\Core\Setup;

class FeedsSetup
{

	public function disable_feed(): void
	{
		wp_redirect(home_url(), '301');
	}

	public function initialize(): void
	{
		remove_action('wp_head', 'feed_links', 2 );
		remove_action('wp_head', 'feed_links_extra', 3);
		add_action('do_feed', array($this, 'disable_feed'));
		add_action('do_feed_rdf', array($this, 'disable_feed'));
		add_action('do_feed_rss', array($this, 'disable_feed'));
		add_action('do_feed_rss2', array($this, 'disable_feed'));
		add_action('do_feed_atom', array($this, 'disable_feed'));
		add_action('do_feed_rss2_comments', array($this, 'disable_feed'));
		add_action('do_feed_atom_comments', array($this, 'disable_feed'));
	}
}
