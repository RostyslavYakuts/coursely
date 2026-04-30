import '@/scss/pages/courses/courses.scss';
import {faq} from "@/js/global/components/faq";
import {coursesCategoryFilter} from "@/js/pages/courses/components/coursesCategoryFilter";


window.addEventListener('load', () => {
    coursesCategoryFilter();
    faq();
});