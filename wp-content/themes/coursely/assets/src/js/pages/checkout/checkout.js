import '@/scss/pages/checkout/checkout.scss';
import {checkoutHandler} from "@/js/pages/checkout/components/checkoutHandler";
import {showPassword} from "@/js/pages/checkout/components/showPassword";
import {selectCountries} from "@/js/pages/checkout/components/selectCountries";

showPassword();
selectCountries();
checkoutHandler();