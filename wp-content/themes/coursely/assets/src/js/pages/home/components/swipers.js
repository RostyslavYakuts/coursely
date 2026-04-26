import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
export const swipers = ()=> {
    const LatestPluginSwiper = () => {
        const el = document.querySelector('.latest-plugin-slider');
        if (el) {
            new Swiper('.latest-plugin-slider', {
                modules: [Navigation, Pagination],
                direction: 'horizontal',
                effect: 'slide',
                slidesPerView: 1,
                loop: true,
                navigation: {
                    nextEl: '.latest-plugin-next',
                    prevEl: '.latest-plugin-prev',
                },
                pagination: {
                    el: '.latest-plugin-pagination',
                    clickable: true
                }

            });
        }


    }
    LatestPluginSwiper();
}