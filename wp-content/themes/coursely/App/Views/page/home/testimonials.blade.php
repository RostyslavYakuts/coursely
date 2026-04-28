{{-- Home testimonials --}}

<section id="testimonials" class="w-full mt-[120px]">
    <div class="container mx-auto">
        <h2 class="text-center text-brand-dark text-[32px] lgx:text-[48px] ">{{$data['testimonials_title']}}</h2>
        <p class="mt-5 text-lg text-brand-text text-center">{{$data['testimonials_description']}}</p>

        <div class="relative mt-10">
                <div class="swiper mt-[40px] l:mt-[0px] overflow-hidden max-w-full testimonials-container testimonials-container-js">
                    <div class="swiper-wrapper">
                        @if($data['testimonials_slider'])
                            @foreach($data['testimonials_slider'] as $testimonial)
                                <div class="swiper-slide py-[32px] px-[24px] flex-col">
                                    <div class=" flex justify-between items-center">
                                        <div class="flex flex-row gap-5">
                                            <img class="w-[62px] h-[62px] rounded-full object-cover"
                                                 loading="lazy"
                                                 decoding="async"
                                                 width="62"
                                                 height="62"
                                                 src="{{$testimonial['screenshot']['url']}}"
                                                 alt="{{$testimonial['screenshot']['alt']}}"
                                            >
                                            <div class="flex flex-col gap-1">
                                                <span class="text-base font-semibold xmm:text-lg text-brand-dark">{{$testimonial['name']}}</span>
                                                <span class="text-sm xmm:text-base text-[#66708599]">{{$testimonial['role']}}</span>
                                            </div>

                                        </div>
                                        <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M23.25 29.0625H11.8381C12.1982 26.6645 13.0545 24.368 14.3522 22.3197C15.6499 20.2713 17.3606 18.5161 19.375 17.1662L22.8431 14.8412L20.7119 11.625L17.2437 13.95C14.3245 15.8954 11.9306 18.5313 10.2744 21.6239C8.6183 24.7165 7.75118 28.17 7.75 31.6781V44.5625C7.75 45.5902 8.15826 46.5758 8.88496 47.3025C9.61166 48.0292 10.5973 48.4375 11.625 48.4375H23.25C24.2777 48.4375 25.2633 48.0292 25.99 47.3025C26.7167 46.5758 27.125 45.5902 27.125 44.5625V32.9375C27.125 31.9098 26.7167 30.9242 25.99 30.1975C25.2633 29.4708 24.2777 29.0625 23.25 29.0625ZM50.375 29.0625H38.9631C39.3232 26.6645 40.1795 24.368 41.4772 22.3197C42.7749 20.2713 44.4856 18.5161 46.5 17.1662L49.9681 14.8412L47.8563 11.625L44.3687 13.95C41.4495 15.8954 39.0556 18.5313 37.3994 21.6239C35.7433 24.7165 34.8762 28.17 34.875 31.6781V44.5625C34.875 45.5902 35.2833 46.5758 36.01 47.3025C36.7367 48.0292 37.7223 48.4375 38.75 48.4375H50.375C51.4027 48.4375 52.3883 48.0292 53.115 47.3025C53.8417 46.5758 54.25 45.5902 54.25 44.5625V32.9375C54.25 31.9098 53.8417 30.9242 53.115 30.1975C52.3883 29.4708 51.4027 29.0625 50.375 29.0625Z" fill="#1C55E0"/>
                                        </svg>
                                    </div>

                                    <p class="mt-8 text-sm xmm:text-base text-brand-text">
                                        {!! $testimonial['feedback'] !!}
                                    </p>

                                </div>

                            @endforeach
                        @endif
                    </div>
                </div>

            <div class="w-full mx-auto max-w-[587px] mt-10 flex justify-between items-center gap-5">
                <button aria-label="Prev" class="testimonials-prev cursor-pointer select-none">
                    <svg width="32" height="27" viewBox="0 0 32 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.5536 1L0.999353 13.5539M0.999353 13.5539L13.3749 25.9294M0.999353 13.5539L30.166 13.5539" stroke="#111230" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="testimonials-swiper-pagination flex justify-center items-center"></div>
                <button aria-label="Next" class="testimonials-next cursor-pointer select-none">
                    <svg width="32" height="27" viewBox="0 0 32 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.6124 1L30.1667 13.5539M30.1667 13.5539L17.7911 25.9294M30.1667 13.5539L1 13.5539" stroke="#111230" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

        </div>


    </div>
</section>