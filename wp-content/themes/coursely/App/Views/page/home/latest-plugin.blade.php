{{-- Home Latest Plugin Section --}}
@php
    /**
    * @var array $data
    */
    if(!$data['latest_plugin_images']) return;
@endphp
<section id="latest_plugin" class="w-full bg-gradient-to-b from-white to-gray-50 py-[50px]">

    <div class="container mx-auto flex flex-col gap-12">

        {{-- Plugin Info --}}
        <div class="x-animation flex flex-col gap-3">

            <span data-animate="up"  class="uppercase tracking-widest text-sm text-brand font-semibold">
                {!! __('Latest Development','ws') !!}
            </span>

            <h2 data-animate="up"  class="text-4xl lg:text-5xl font-light text-brand leading-tight">
                {!! $data['latest_plugin_title'] !!}
            </h2>

            <div data-animate="down"  class="text-gray-600 text-lg leading-relaxed">
                {!! $data['latest_plugin_description'] !!}
            </div>

        </div>

        {{-- Plugin Images --}}
        <div class="relative" data-animate="up">

            <div class="swiper latest-plugin-slider">
                <div class="swiper-wrapper">

                    @foreach($data['latest_plugin_images'] as $item)

                        <div class="swiper-slide flex flex-col justify-center items-center gap-4 group">

                            <div class="overflow-hidden">
                                <img src="{{$item['image']['url']}}"
                                     alt="{{$item['image']['alt']}}"
                                     loading="lazy"
                                     decoding="async"
                                     width="400"
                                     height="400"
                                     class="bg-brand w-full h-[400px] max-h-[400px] lg:h-[500px] lg:max-h-[500px] object-contain">
                            </div>

                            <div class="p-6">
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{$item['description']}}
                                </p>
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>
            {{-- arrows --}}
            <div class="hidden lg:flex pointer-events-none z-10 absolute top-1/2 -translate-y-1/2 w-full justify-between">

                <button aria-label="Prev"
                        class="latest-plugin-prev pointer-events-auto flex items-center justify-center
                               w-12 h-12 rounded-full border border-brand
                               text-brand bg-white hover:bg-brand hover:text-white
                               transition shadow-md">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18L9 12L15 6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>

                <button aria-label="Next"
                        class="latest-plugin-next pointer-events-auto flex items-center justify-center
                               w-12 h-12 rounded-full border border-brand
                               text-brand bg-white hover:bg-brand hover:text-white
                               transition shadow-md">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M9 6L15 12L9 18"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>

            </div>

            <div class="latest-plugin-pagination mt-5 flex justify-center"></div>

        </div>

        @include('global.brand-btn',[
            'data'=>[
                'data_animate'=>'down',
                'rel'=>'noopener noreferrer',
                'target'=>'',
                'tw_classes'=>'text-white hover:text-brand-accent w-[300px] mx-auto transition-all duration-700',
                'button_link'=>$data['latest_plugin_link'] ?? '',
                'button_title'=>__('Gutenberg Slider Block Plugin','ws'),
            ]
            ])

    </div>

</section>
