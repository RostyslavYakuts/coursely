import * as $ from 'jquery';

export const expandAllModules = ()=>{
    $('.expand-all-modules-js').on('click',function(){
        const $button = $(this);
        const $blocks = $('.module');
        const $lessons = $('.module-lessons');

        if ($button.hasClass('active')) {

            $button.removeClass('active');

            $blocks.removeClass('active');
            $lessons.slideUp(300);

        } else {

            $button.addClass('active');

            $blocks.addClass('active');
            $lessons.slideDown(300);
        }
    });
}
