<?php

namespace coursely\App\Core\Helpers;

class FilterDataCustomisationHelper
{
	public function __construct(){
		add_filter('the_content', [$this,'add_ids_to_header_tags'],10, 1 );
		add_filter('term_description', [$this, 'add_ids_to_header_tags'], 10);
		add_filter('post_total_reading_time', [$this, 'post_total_reading_time'], 10);
		add_filter('paginate_links', [$this, 'paginationLinks']);
		add_filter('convert_date_format', array($this, 'convert_date_format'));
		//add_filter('product_status',[$this,'product_status']);
		//add_filter('product_size',[$this,'product_size']);
		//add_action('wp_head', [$this,'add_hreflang']);
	}

	public function add_hreflang(): void
	{
		if ( is_admin() || is_feed() ) {
			return;
		}
		$current_url = home_url( add_query_arg( null, null ) );
		echo '<link rel="alternate" hreflang="uk" href="' . esc_url( $current_url ) . '" />' . "\n";
		echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $current_url ) . '" />' . "\n";
	}

	/**
	 * This function automatically adds id attributes to <h1>–<h6> tags in post content or term descriptions
	 * @param $content
	 * @return array|mixed|string|string[]
	 */
	public function add_ids_to_header_tags($content ): mixed
	{

		$pattern = '#(?P<full_tag><(?P<tag_name>h\d)(?P<tag_extra>[^>]*)>(?P<tag_contents>[^<]*)</h\d>)#i';
		if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
			$find = array();
			$replace = array();
			foreach( $matches as $match ) {
				if ( strlen( $match['tag_extra'] ) && false !== stripos( $match['tag_extra'], 'id=' ) ) {
					continue;
				}
				$find[]    = $match['full_tag'];
				$id        = sanitize_title( $match['tag_contents'] );
				$id_attr   = sprintf( ' id="%s"', $id );
				$replace[] = sprintf( '<%1$s%2$s%3$s>%4$s</%1$s>', $match['tag_name'], $match['tag_extra'], $id_attr, $match['tag_contents']);
			}
			$content = str_replace( $find, $replace, $content );
		}
		return $content;
	}
	public function post_total_reading_time($content): string
	{
		$word_count = self::count_word($content);
		return ceil($word_count / 200);
	}
	public static function count_word($content): int
	{
		$cleaned_content = strip_tags($content);
		return count(preg_split('/\s+/', trim($cleaned_content)));
	}
	public function product_size($size): string
	{
		return match ($size) {
				'small' => 'S',
				'medium' => 'M',
				'large' => 'L',
				default => 'M',
			};

	}
	public function product_status($product_status): string {
		return match ($product_status) {
			'actual' => 'В наявності',
			'discount' => 'Знижка',
			'sold' => 'Продано',
			default => 'В наявності',
		};
	}
	public function paginationLinks ($link){
		if(is_paged()){
			$link= str_replace('/page/1/', '/', $link);
		}
		return $link;
	}
	public function convert_date_format($date): string
	{
		return \DateTime::createFromFormat('d/m/Y', $date)->format('d F Y');
	}


}
