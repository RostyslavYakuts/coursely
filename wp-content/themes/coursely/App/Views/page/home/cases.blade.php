{{-- Cases Home --}}
@php
    /**
    * @var array $data
    */
    if(!$data['cases']) return;
@endphp
<section class="bg-white w-full">
    <div id="cases" class="container mx-auto py-[100px] border-t border-brand/20">
        <div class="flex flex-col gap-3">
            <span data-animate="up" class="uppercase tracking-widest text-sm text-brand font-semibold">
                {!! __('Cases','ws') !!}
            </span>
            <h2 data-animate="up" class="text-4xl lg:text-5xl font-light text-brand leading-tight">
                {{$data['cases_title']}}
            </h2>
            <p data-animate="down" class="text-gray-600 text-lg leading-relaxed">
                {{ $data['cases_description'] }}
            </p>

        </div>

        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-3 gap-6 mt-16" data-animate="up">

            @foreach($data['cases'] as $case)

                        <a target="_blank"
                           class="swiper-slide group p-6 bg-white border border-gray-200 rounded-2xl shadow-sm
                                  hover:shadow-xl transition duration-500 flex flex-col gap-4 h-auto"
                           href="{{$case['link']}}">

                            <div class="overflow-hidden rounded-xl">
                                <img width="200" height="200"
                                     loading="lazy"
                                     decoding="async"
                                     src="{{ $case['image']['url'] }}"
                                     alt="{{$case['title']}}"
                                     class="w-full h-[220px] object-cover
                                            transition duration-700
                                            group-hover:scale-105">
                            </div>

                            <h3 class="pt-2 text-lg font-semibold text-gray-800
                                       group-hover:text-brand transition">
                                {{$case['title']}}
                            </h3>

                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{$case['description']}}
                            </p>

                        </a>

                    @endforeach

        </div>

    </div>
</section>