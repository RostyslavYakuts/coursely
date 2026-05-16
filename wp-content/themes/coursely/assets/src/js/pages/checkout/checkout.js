import '@/scss/pages/checkout/checkout.scss';
import {checkoutHandler} from "@/js/pages/checkout/components/checkoutHandler";
import {selectCountries} from "@/js/pages/checkout/components/selectCountries";

selectCountries();
void checkoutHandler();