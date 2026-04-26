import * as $ from 'jquery'
export const TOCList = () => {
	$('.js-toc_table_list_heading ul li a').on("click", function (e) {
		e.preventDefault();
		const id = $(this).attr("href");
		const top = $(id).offset().top - 115;
		$('html, body').animate({scrollTop: top}, 500);
	});
}
