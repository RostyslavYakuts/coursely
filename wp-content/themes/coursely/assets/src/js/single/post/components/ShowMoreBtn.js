import * as $ from 'jquery';

export const ShowMoreBtn = () => {
	$('body').on('click','.js-show-more-items',function(){
		const $parentBlock = $(this).parent();
		const $this = $(this);
		const itemType = $this.data('item-type');
		$parentBlock.find($(`.${itemType}-item`)).slideDown();
		$parentBlock.find($(`.${itemType}-separator`)).show();
		$this.hide();
	});
}
