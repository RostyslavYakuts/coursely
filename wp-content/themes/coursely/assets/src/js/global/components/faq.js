import * as $ from 'jquery';
export const faq = () => {
    if(!$('.faq-wrapper')){
        return;
    }
    $('.faq-block.active .answer').show();

    $('.question-js').on('click', function () {
        const $block = $(this).parent('.faq-block');
        const $answer = $block.find('.answer');

        if ($block.hasClass('active')) {
            $block.removeClass('active');
            $answer.slideUp(300);
        } else {
            $block.addClass('active');
            $answer.slideDown(300);
        }
    });
};