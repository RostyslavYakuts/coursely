{{-- Home Bestsellers --}}
@php
    /**
     * @var array $data
     */
    $services = $data['services'];
    if(!$services) return;
@endphp
<section class="w-full container mx-auto py-[100px]">
    <div class="x-animation flex flex-col gap-3">
            <span data-animate="up" class="uppercase tracking-widest text-sm text-brand font-semibold">
                {!! __('Services','ws') !!}
            </span>
        <h2 data-animate="up" class="text-4xl lg:text-5xl font-light text-brand leading-tight">
            {{$data['services_section_title']}}
        </h2>
        <p data-animate="down" class="text-gray-600 text-lg leading-relaxed">
            {{ $data['services_section_description'] }}
        </p>

    </div>
    <div class="max-w-7xl mx-auto px-6 text-center py-[100px] flex flex-row justify-between items-start gap-10 relative">
            @if ($services->have_posts())

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">

                    @while ($services->have_posts())
                        @php
                            $services->the_post();

                            $post_id   = get_the_ID();
                            $title     = get_the_title($post_id);
                            $link      = get_permalink($post_id);
                            $image     = get_the_post_thumbnail_url($post_id,'medium');
                            $date      = get_the_date('F d, Y', $post_id);
                            $excerpt   = get_the_excerpt($post_id);
                        @endphp

                        <a href="{{ $link }}"
                           class="p-10 bg-gray-50 rounded-3xl shadow-lg hover:shadow-2xl" data-animate="up">
                            <div class="overflow-hidden rounded-xl mb-4">
                                <img width="300" height="300"
                                     loading="lazy"
                                     decoding="async"
                                     src="{{ $image }}"
                                     alt="{{ $title }}"
                                     class="w-full h-[220px] object-cover
                                        transition duration-700
                                        group-hover:scale-105">
                            </div>
                            <h3 class="text-xl font-semibold mb-3">{{$title}}</h3>
                            <p class="text-gray-500">{{$excerpt}}</p>
                        </a>

                    @endwhile

                </div>

                @php wp_reset_postdata(); @endphp

            @endif

    </div>
</section>