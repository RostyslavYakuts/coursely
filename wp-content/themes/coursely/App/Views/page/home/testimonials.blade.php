{{-- Home testimonials --}}

<section id="testimonials" class="w-full bg-brand-light-orange py-[60px] l:py-[80px]">
    <div class="container mx-auto">
        <div class="w-full flex flex-col l:flex-row l:justify-between l:items-start">
            <div class="l:min-h-[375px] gap-[40px] flex flex-col justify-between">
                <div class="text-lite-black flex flex-col gap-[20px] l:gap-[40px] w-full l:max-w-[460px]">
                    <h2 class="text-3xl">{{$data['testimonials_title']}}</h2>
                    <p>{{$data['testimonials_description']}}</p>
                </div>
            </div>
            <div class="relative">
                <div class="swiper mt-[40px] l:mt-[0px] overflow-hidden max-w-full h-[400px] md:h-[320px] md:max-w-[670px] testimonials-container testimonials-container-js">
                    <div class="swiper-wrapper">
                        @if($data['testimonials_slider'])
                            @foreach($data['testimonials_slider'] as $testimonial)
                                <div class="swiper-slide">
                                    <div class="bg-white py-[19px] px-[24px] h-[400px]  md:h-[320px] flex flex-col justify-between">
                                        <div class="flex flex-col gap-[12px] text-brand-gold">
                                            <span class="block max-h-[40px] leading-none text-[96px]">“</span>
                                            <p class="text-sm xmm:text-base">{!! $testimonial['feedback'] !!}</p>
                                        </div>
                                        <div class="flex flex-row justify-end items-center">
                                            <div class="flex flex-row items-center gap-4">
                                                <img class="w-[100px] h-[100px] object-cover rounded-full p-1 border border-brand-gold shadow"
                                                     width="100"
                                                     height="100"
                                                     loading="lazy"
                                                     decoding="async"
                                                     src="{{$testimonial['screenshot']['url']}}"
                                                     alt="{{$testimonial['screenshot']['alt']}}">
                                                <div class="flex flex-col gap-1 text-brand-gold">
                                                    <span class="text-base font-semibold xmm:text-lg">{{$testimonial['name']}}</span>
                                                    <span class="text-sm xmm:text-base">{{$testimonial['role']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <button aria-label="Prev" class="testimonials-prev absolute hidden md:block -left-5 xl:-left-[50px] top-1/2 -translate-y-1/2 z-20
                text-brand-gold text-4xl cursor-pointer select-none px-3 hover:text-white hover:bg-lite-black">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </button>
                <button aria-label="Next" class="testimonials-next absolute hidden md:block -right-5 xl:-right-[50px] top-1/2 -translate-y-1/2 z-20
                text-brand-gold text-4xl cursor-pointer select-none px-3 hover:text-white hover:bg-lite-black">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </button>
                <div class="testimonials-swiper-pagination flex justify-center items-center gap-2 mt-4"></div>
            </div>

        </div>
    </div>
</section>