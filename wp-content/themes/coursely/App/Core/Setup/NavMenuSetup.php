<?php

namespace coursely\App\Core\Setup;


class NavMenuSetup
{
	public function __construct(){
		$this->initialize();
	}
	/**
	 * Menu change a[href=""] to span
	 */

	public function my_walker_nav_menu_start_el($item_output, $item, $depth, $args)
	{
        $is_empty = empty($item->url) || $item->url === '#';
        $is_current = $item->current;
        $is_anchor = str_contains($item->url,'#');
        $is_contact = str_contains($item->url,'#contact');

        if (!$is_anchor && ($is_empty || $is_current)) {
            $item_output  = $args->before;
            $item_output .= '<span class="empty-link">';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</span>';
            $item_output .= $args->after;
            return $item_output;
        }

        if ($is_anchor) {
            if($is_contact){
                $item_output = preg_replace(
                    '/<a\b(?![^>]*class=)/i',
                    '<a class="anchor-link-js anchor-contact-js" ',
                    $item_output
                );
            }else{
                $item_output = preg_replace(
                    '/<a\b(?![^>]*class=)/i',
                    '<a class="anchor-link anchor-link-js" ',
                    $item_output
                );
            }


            return $item_output;
        }

        return $item_output;
	}
	public function my_css_attributes_filter($var): array|string
	{
		return is_array($var) ? array_intersect($var, array('current-menu-item', 'menu-item-has-children')) : '';
	}
    private function register_menus(): void
    {
        register_nav_menus([
            'main_menu'   => __('Main Menu', 'di'),
            'footer_menu'   => __('Footer Menu', 'di'),
        ]);
    }

	public function initialize(): void
	{
		add_filter('walker_nav_menu_start_el', [$this, 'my_walker_nav_menu_start_el'], 10, 4);
		add_filter('nav_menu_css_class', [$this, 'my_css_attributes_filter']);
		add_filter('nav_menu_item_id', [$this, 'my_css_attributes_filter']);
		add_filter('page_css_class', [$this, 'my_css_attributes_filter']);
        $this->register_menus();
	}
}
