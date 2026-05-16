import {recaptcha} from "@/js/global/components/recaptcha";

let recaptchaShown = false;

function triggerRecaptchaOnce() {
    if (recaptchaShown) return;
    recaptchaShown = true;
    recaptcha();
}

function bindFormFields() {
    document.querySelectorAll('form input, form textarea, form select')
        .forEach(el => {
            el.addEventListener('focus', triggerRecaptchaOnce, { once: true });
        });
}

function bindStripeFields(fields) {
    fields.forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;

        el.addEventListener('click', triggerRecaptchaOnce, { once: true });
        el.addEventListener('focusin', triggerRecaptchaOnce, { once: true });
    });
}

export const recaptchaBinder = (stripeFieldIds = []) => {
    bindFormFields();
    bindStripeFields(stripeFieldIds);
};