import './components/hamburger';
import {hamburger} from "./components/hamburger";
import {scrollToTop} from "./components/scrollToTop";
import {authPopup} from "@/js/global/components/authPopup";
import {authHandler} from "@/js/global/components/authHandler";
import {recaptcha} from "@/js/global/components/recaptcha";
import {cancelSubscription} from "@/js/global/components/cancelSubscription";
import {recaptchaBinder} from "@/js/global/components/recaptchaBinder";
import {showPassword} from "@/js/global/components/showPassword";

export const global = ()=>{
	hamburger();
	scrollToTop();
	authPopup();
	authHandler();
	showPassword();
	cancelSubscription();
	recaptchaBinder();
}


