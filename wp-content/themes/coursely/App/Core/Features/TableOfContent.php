<?php

namespace coursely\App\Core\Features;
/**
 *
 */
class TableOfContent
{
	private string $content;

	private string $modified_content;
	private int $count;
	private $title;
	private array $level;
	private array $text;
	private string $place = 'title';
	private string $shortcode = "#<!--\[toc\]-->#is";

	private $match;

	/**
	 * @param $content
	 */
	public function __construct($content)
	{
		//preg_match_all("#<[hH]([1-4])(.*?)>(.*?)</[hH][1-4]>#is", $content, $match);
		$this->content = $content;
		$this->modified_content = $this->add_ids_to_header_tags($this->content);
		preg_match_all('/<[hH]([1-6])*[^>]*>(.*?)<\/[hH][1-6]>/', $this->modified_content, $match);
		$this->count = count($match[0]);
		$this->title = $match[0];
		$this->level = $match[1];
		$this->text = $match[2];
		$this->match = $match;
		//apply_filters('the_content',array($this->add_ids_to_header_tags($this->content)));
	}

	public function generateIndex($custom_li = '',$hierarchy = false): string
	{
		if( $hierarchy ){
			$dataToc = $this->getDataToc();
		}else{
			$dataToc = $this->getDataTocNoHierarchy();
		}
		$html = '';
		$style = '';
		$iterator = 1;
		$data_toc_iterator = 0;
		foreach($dataToc as $dt){
			if( $dt['href'] ){
				$data_toc_iterator++;
			}
		}
		$count = $data_toc_iterator;
		$consists_with_hidden = $count > 6;
		foreach ($dataToc as $item) {

			if( $iterator > 6 ){
				$style = 'style="display:none;"';
			}
			if ($item['list_open']) {
				$html .= '<ul class="toc-ul py-1 bg-gray-100">';
			}
			if( $iterator === 1){
				$html .= $custom_li;
			}
			if ($item['item_open']) {
				$html .= '<li data-level="'.$item['level'].'" class="toc-item" ' .$style.'>';
			}
			if ($item['text'] && $item['href']) {
				$html .= '<a class="font-bold" href="' . $item['href'] . '" title="' . $item['text'] . '">' . $item['text'] . '</a>';
			}
			if ($item['item_close']) {
				$html .= '</li>';
			}

			if ($item['list_close']) {
				$html .= '</ul>';
			}
			$iterator++;
		}
		if( $consists_with_hidden ){
			$html .= '<li class="font-bold block cursor-pointer text-brand-accent text-center btn-show-more-items js-show-more-items"
			 data-item-type="toc"
			  data-max-displayed="6">' . ' +' . ($count - 6) . ' ' . __('Show all','ws') . '</li>';
		}
		if( $hierarchy === false && $html ){
			$html = '<ul class="toc-ul py-1 bg-gray-100">'.$html.'</ul>';
		}

		return $html;
	}

	private function add_ids_to_header_tags($content): string
	{
		$pattern = '#(?P<full_tag><(?P<tag_name>h\d)(?P<tag_extra>[^>]*)>(?P<tag_contents>[^<]*)</h\d>)#i';
		if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
			$find = array();
			$replace = array();
			foreach ($matches as $match) {
				if ($match['tag_extra'] !== '' && false !== stripos($match['tag_extra'], 'id=')) {
					continue;
				}
				$find[] = $match['full_tag'];
				$id = sanitize_title($match['tag_contents']);
				$id_attr = sprintf(' id="%s"', $id);
				$replace[] = sprintf('<%1$s%2$s%3$s>%4$s</%1$s>', $match['tag_name'], $match['tag_extra'], $id_attr, $match['tag_contents']);
			}
			$content = str_replace($find, $replace, $content);
		}
		return $content;
	}

	/**
	 * Creates an array of table of contents data structure.
	 *
	 * @return array
	 */
	private function getDataToc(): array
	{

		$toc = [];

		$count = $this->count;
		$level = $this->level;
		//echo'<pre>'.print_r($level,true).'</pre>';
		$text = $this->text;
		if ($count === 0 || $count === 1) {
			return [];
		}

		for ($i = 0, $j = 0; $i < $count; $i++, $j++) {
			$toc[$i]['level'] = $this->level[$i];
			// the first header
			if ($i === 0) {
				$toc[$i]['list_open'] = true;
				$toc[$i]['item_open'] = true;
				$toc[$i]['text'] = $text[$i];
				$toc[$i]['href'] = '#' . sanitize_title($this->getHref($text[$i]));
				$toc[$i]['item_close'] = $level[$i] === $level[$i + 1] || (!isset($level[$i + 1]));
				$toc[$i]['list_close'] = $level[$i] > $level[$i + 1] || (!isset($level[$i + 1]));

				continue;
			}

			// the last header
			if ($i === $count - 1) {
				$toc[$j]['list_open'] = $level[$i] > $level[$i - 1];
				$toc[$j]['item_open'] = true;
				$toc[$j]['text'] = $text[$i];
				$toc[$j]['href'] = '#' . sanitize_title($this->getHref($text[$i]));
				$toc[$j]['item_close'] = true;
				$toc[$j]['list_close'] = $level[$i] > $level[$i - 1];

				++$j;
				$toc[$j]['list_open'] = false;
				$toc[$j]['item_open'] = false;
				$toc[$j]['text'] = "";
				$toc[$j]['href'] = "";
				$toc[$j]['item_close'] = true;
				$toc[$j]['list_close'] = true;

				break;
			}


			//other header
			$toc[$j]['list_open'] = $level[$i] > $level[$i - 1];
			$toc[$j]['item_open'] = true;
			$toc[$j]['text'] = $text[$i];
			$toc[$j]['href'] = '#' . sanitize_title($this->getHref($text[$i]));
			$toc[$j]['item_close'] = $level[$i] >= $level[$i + 1];
			$toc[$j]['list_close'] = $level[$i] > $level[$i + 1];

			if ($level[$i] > $level[$i + 1]) {
				$j++;
				$toc[$j]['list_open'] = false;
				$toc[$j]['item_open'] = false;
				$toc[$j]['text'] = "";
				$toc[$j]['href'] = "";
				$toc[$j]['item_close'] = true;
				$toc[$j]['list_close'] = false;
			}
		}

		return $toc;
	}

	private function getDataTocNoHierarchy(): array
	{
		$toc = [];
		$count = $this->count;
		$text = $this->text;

		if ($count <= 1) {
			return [];
		}

		for ($i = 0; $i < $count; $i++) {
			$toc[$i]['level'] = $this->level[$i];
			$toc[$i]['list_open'] = false;
			$toc[$i]['item_open'] = true;
			$toc[$i]['text'] = $text[$i];
			$toc[$i]['href'] = '#' . sanitize_title($this->getHref($text[$i]));
			$toc[$i]['item_close'] = true;
			$toc[$i]['list_close'] = false;
		}

		return $toc;
	}

	/**
	 * @access protected
	 * @param $str
	 * @return string
	 */
	private function getHref($str): string
	{
		return str_replace(' ', '-', $str);
	}

}
