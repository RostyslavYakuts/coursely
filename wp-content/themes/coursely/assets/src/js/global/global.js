import './components/hamburger';
import {hamburger} from "./components/hamburger";
import {scrollToTop} from "./components/scrollToTop";
import {authPopup} from "@/js/global/components/authPopup";
import {authHandler} from "@/js/global/components/authHandler";
import {recaptcha} from "@/js/global/components/recaptcha";
import {cancelSubscription} from "@/js/global/components/cancelSubscription";



export const global = ()=>{
	hamburger();
	scrollToTop();
	authPopup();
	authHandler();
	cancelSubscription();
	document.querySelectorAll('form input, form textarea').forEach(el => {
		el.addEventListener('focus', () => {
			recaptcha();
		}, { once: true });
	});
}


