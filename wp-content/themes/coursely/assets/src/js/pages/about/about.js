import '@/scss/pages/about/about.scss';
import {testimonialsSwiper} from "@/js/pages/home/components/testimonialsSwiper";
import {faq} from "@/js/global/components/faq";


window.addEventListener('load', () => {
    testimonialsSwiper();
    faq();
});