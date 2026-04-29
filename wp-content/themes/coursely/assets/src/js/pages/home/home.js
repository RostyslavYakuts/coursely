import '@/scss/pages/home/home.scss';

import {AnimateNumbers} from "@/js/pages/home/components/AnimateNumbers";
import {animation} from "@/js/pages/home/components/animation";
import {workflowAnimation} from "@/js/pages/home/components/workflowAnimation";
import {marqueeSlider} from "@/js/pages/home/components/marqueeSlider";
import {swipers} from "@/js/pages/home/components/swipers";
import {homeCategoryFilter} from "@/js/pages/home/components/homeCategoryFilter";
import {testimonialsSwiper} from "@/js/pages/home/components/testimonialsSwiper";
import {faq} from "@/js/global/components/faq";

window.addEventListener('load', () => {
    homeCategoryFilter();
    testimonialsSwiper();
    faq();
});
