{{-- Top Articles Blog --}}
<section class="container mx-auto py-[100px] flex flex-col gap-6">
    <h2 class="text-3xl">{{$data['top_articles_title']}}</h2>
    <p class="">{{$data['top_articles_description']}}</p>
    @if($data['top_articles'])
        <div class="mt-5 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($data['top_articles'] as $index => $article)
                @php $id=$article['article']; @endphp
                <article class="group bg-white border border-brand/20
                        rounded-xl overflow-hidden
                        hover:shadow-lg transition">

                    <a href="{{ get_permalink($id) }}">

                        <div class="aspect-[4/3] overflow-hidden">
                            {!! get_the_post_thumbnail(
                                $id,
                                'medium_large',
                                [
                                    'class' =>
                                    'w-full h-full object-cover
                                     group-hover:scale-105 transition duration-500'
                                ]
                            ) !!}
                        </div>

                        <div class="p-5 flex flex-col gap-3">

                            <h3 class="text-lg font-semibold line-clamp-3
                               group-hover:text-brand transition">
                                {{ get_the_title($id) }}
                            </h3>
                            <span class="text-sm uppercase text-brand">
                                {!! __('Read More','ws') !!} →
                            </span>

                        </div>

                    </a>
                </article>

            @endforeach

        </div>
    @endif
</section>