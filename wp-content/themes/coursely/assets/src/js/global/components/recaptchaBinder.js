import {recaptcha} from "@/js/global/components/recaptcha";

let recaptchaShown = false;

function initLoggedUser() {
    if (recaptchaShown) return;
    recaptchaShown = true;
    recaptcha();
}

function initGuestUser() {
    document.querySelectorAll('form input, form textarea, form select').forEach(el => {
        el.addEventListener('focus', () => {
            recaptcha();
        }, { once: true });
    });
}

export const recaptchaBinder = () => {
    const isLoggedIn = typeof window.userLocalizedScript !== 'undefined';

    if (isLoggedIn) {
        initLoggedUser();
    } else {
        initGuestUser();
    }
};