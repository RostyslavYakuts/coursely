{{-- Posts Tag --}}
@php
    /**
    * @var array $data
     */

    $posts = $data['default_posts'] ?? [];

@endphp

{{-- Posts Category --}}
@php
    /**
     * @var array $data
     */
    $posts = $data['default_posts'] ?? [];
    if(!$posts) return;
@endphp

<div class="container mx-auto py-[100px] flex flex-row justify-between items-start gap-10 relative">
    <div id="default_posts" class="mt-10 w-full">

        @if ($posts->have_posts())

            <div class="default-products-list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mdx:gap-8">

                @while ($posts->have_posts())
                    @php
                        $posts->the_post();

                        $post_id   = get_the_ID();
                        $title     = get_the_title($post_id);
                        $link      = get_permalink($post_id);
                        $image     = get_the_post_thumbnail_url($post_id,'medium');
                        $date      = get_the_date('F d, Y', $post_id);
                        $excerpt   = get_the_excerpt($post_id);
                    @endphp

                    <a href="{{ $link }}"
                       class="group border border-gray-200 hover:border-brand
                              rounded-2xl w-full h-full p-4
                              flex flex-col justify-between
                              bg-white shadow-sm hover:shadow-xl
                              transition duration-500">

                        {{-- Image --}}
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

                        {{-- Title --}}
                        <h3 title="{{ $title }}"
                            class="text-gray-900 group-hover:text-brand
                                   text-lg font-semibold text-center
                                   line-clamp-3 min-h-[72px]
                                   transition-colors">
                            {{ $title }}
                        </h3>

                        {{-- Meta --}}
                        <div class="text-sm text-gray-500 flex flex-col items-center gap-1 mt-2">
                            <span>{{ $date }}</span>
                        </div>

                        {{-- Excerpt --}}
                        <p class="text-sm text-gray-600 text-center line-clamp-2 mt-3">
                            {{ $excerpt }}
                        </p>

                        {{-- Button --}}
                        <span class="mt-5 text-center uppercase tracking-wider
                                     bg-brand hover:bg-brand-hover
                                     text-white py-3 rounded-lg
                                     transition">
                           {!! __('Learn more','ws') !!}
                        </span>

                    </a>

                @endwhile

            </div>

            @if($posts->max_num_pages > 1)
                <div class="flex justify-center mt-12">
                    <button
                            data-page="1"
                            data-term-id="{{ $data['id'] }}"
                            data-max-num-pages="{{ $posts->max_num_pages }}"
                            class="rounded-xl bg-brand hover:bg-brand-hover
                               text-white px-8 py-4
                               tracking-widest uppercase
                               shadow-md hover:shadow-xl
                               transition load-more-posts load-more-posts-js">
                        {!! __('Show more','ws') !!}
                    </button>
                </div>
            @endif

            @php wp_reset_postdata(); @endphp

        @endif

    </div>
</div>
