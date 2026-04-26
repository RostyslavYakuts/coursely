import '@/scss/pages/contacts/contacts.scss';
import {contactFormHandler} from "@/js/pages/contacts/components/contactFormHandler";
import {recaptcha} from "@/js/global/components/recaptcha";


document.querySelectorAll('form input, form textarea').forEach(el => {
    el.addEventListener('focus', () => {
        recaptcha();
    }, { once: true });
});
contactFormHandler();