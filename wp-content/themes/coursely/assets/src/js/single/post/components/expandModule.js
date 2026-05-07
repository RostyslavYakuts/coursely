import * as $ from 'jquery';

export const expandModule = () => {

    $('.module-expandable-js').on('click', function () {

        const $block = $(this).parent();
        const $lessons = $block.find('.module-lessons');

        if ($block.hasClass('active')) {

            $block.removeClass('active');
            $lessons.slideUp(300);

        } else {

            $block.addClass('active');
            $lessons.slideDown(300);
        }
    });
}