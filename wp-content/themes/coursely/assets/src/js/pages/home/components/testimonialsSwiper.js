import Swiper from 'swiper';
import { Navigation,Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
export const testimonialsSwiper = ()=>{
    const el = document.querySelector('.testimonials-container-js');
    if(el){
        new Swiper('.testimonials-container-js', {
            modules: [Navigation,Pagination],
            direction: 'horizontal',
            effect: 'slide',
            loop: true,
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.testimonials-next',
                prevEl: '.testimonials-prev',
            },
            pagination: {
                el: '.testimonials-swiper-pagination',
                clickable: true
            },
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    }

}
