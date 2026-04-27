import * as $ from 'jquery';
export const authPopup = ()=>{

    const closeAuthPopup = $('.close-popup-btn-js');
    const authPopup = $('.auth-popup-js');
    const authForms = $('.auth-form-js');
    const signUpForm = $('#signup_form');
    const loginForm = $('#login_form');

    closeAuthPopup.on('click',function(){
        authPopup.addClass('hidden');
        authForms.addClass('hidden');
        $('body').removeClass('shadow');
    });

    $('.switch-to-signup-js').on('click',function(){
        loginForm.addClass('hidden');
        signUpForm.removeClass('hidden');
    });

    $('.switch-to-login-js').on('click',function(){
        signUpForm.addClass('hidden');
        loginForm.removeClass('hidden');
    });



    $('.login-js').on('click',function(){
        authPopup.removeClass('hidden');
        $('body').addClass('shadow');
        authForms.addClass('hidden');
        $('#login_form').removeClass('hidden');
    });

    $('.signup-js').on('click',function(){
        authPopup.removeClass('hidden');
        $('body').addClass('shadow');
        authForms.addClass('hidden');
        signUpForm.removeClass('hidden');
    });
}