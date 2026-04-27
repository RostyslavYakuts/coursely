{{-- All posts --}}
@if($data['all_articles']->have_posts())
    <section class="all-articles-section">

        <div class="all-articles-js grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @while($data['all_articles']->have_posts())
                @php $data['all_articles']->the_post(); @endphp

                <article class="group rounded-xl overflow-hidden hover:shadow-lg transition">

                    <a href="{{ get_permalink() }}" class="block">
                        <div class="aspect-[4/3] overflow-hidden">
                            {!! get_the_post_thumbnail(
                                get_the_ID(),
                                'medium_large',
                                ['class'=>'w-full h-full object-cover group-hover:scale-105 transition']
                            ) !!}
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold line-clamp-2 group-hover:text-brand transition">
                                {{ get_the_title() }}
                            </h3>

                            <span class="text-sm text-gray-500 block mt-2">
                            {{ get_the_date() }}
                        </span>
                        </div>
                    </a>

                </article>

            @endwhile
            @php wp_reset_postdata(); @endphp

        </div>

        @if($data['all_articles']->max_num_pages > 1)
            <div class="mt-10">
                <button
                        id="load_more_posts"
                        data-page="1"
                        data-max-num-pages="{{ $data['all_articles']->max_num_pages }}"
                        class="uppercase px-6 py-3 bg-brand text-white rounded-lg hover:bg-brand-hover transition">
                    {!! __('Show more','ws') !!}
                </button>
            </div>
        @endif

    </section>
@endif