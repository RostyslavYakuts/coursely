import '@/scss/single/post/post.scss';

import {expandAllModules} from "@/js/single/post/components/expandAllModules";
import {expandModule} from "@/js/single/post/components/expandModule";
import {faq} from "@/js/global/components/faq";

window.addEventListener('load', () => {
    expandAllModules();
    expandModule();
    faq();
});
