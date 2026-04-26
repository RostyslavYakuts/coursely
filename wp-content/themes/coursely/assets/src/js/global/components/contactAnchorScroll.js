import * as $ from 'jquery';
export const contactAnchorScroll = () => {
    document.addEventListener('click', function (e) {
        const el = e.target.closest('.anchor-contact-js');
        if (!el) return;

        e.preventDefault();

        const target = document.querySelector('#contact');
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
    const $anchor =  $('.anchor-link-js');
    $anchor.on('click', function (e) {
        const url = new URL(this.href, window.location.origin);

        if (url.hash !== '#vision') return; // others: native behavior

        const el = document.querySelector(url.hash);
        if (!el) return;

        e.preventDefault();

        const y = el.getBoundingClientRect().top + window.pageYOffset - 100;

        window.scrollTo({
            top: y,
            behavior: 'smooth'
        });

        // Update URL without jumping
        history.pushState(null, '', url.hash);
    });
    $(window).on('load', function () {
        if (window.location.hash === '#vision') {
            const el = document.querySelector('#vision');
            if (!el) return;

            const y = el.getBoundingClientRect().top + window.pageYOffset - 100;
            window.scrollTo({ top: y, behavior: 'smooth' });
        }
    });
    $anchor.on('click', function () {

        if (window.innerWidth <= 1199) {

            setTimeout(() => {
                $('.hamburger-js').trigger('click');
            }, 500);
        }
    });
}