import * as $ from 'jquery';
export const showPassword = ()=>{

    const $toggle = $('.togglePassword');

    $toggle.on('click',function(){
        const inputId = $(this).data('input');
        const $input = $('#' + inputId);

        const isPassword = $input.attr('type') === 'password';

        $input.attr('type', isPassword ? 'text' : 'password');
    })
}