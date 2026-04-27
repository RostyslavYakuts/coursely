{{-- Author Posts --}}
@php
    /**
     * @var array $data
     */
    if(!$data['author_articles']) return;
@endphp
<section class="container mx-auto py-[120px]">
    <h2 class="text-4xl font-light text-center mb-16 tracking-widest text-gray-800">
        {!! __('All authors posts','ws') !!}
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
        @foreach($data['author_articles'] as $article)
            <a href="{{ $article['permalink'] }}"
               class="group relative bg-white rounded-2xl overflow-hidden shadow-md
                      hover:shadow-2xl transition duration-500
                      p-6 flex flex-col h-full">

                {{-- Thumbnail --}}
                <div class="overflow-hidden mb-6 rounded-xl">
                    <img src="{{ $article['thumbnail'] }}"
                         alt="{{ $article['title'] }}"
                         class="w-full h-56 object-cover transition-transform duration-700
                                group-hover:scale-105">
                </div>

                {{-- Title --}}
                <h3 class="text-lg font-medium text-gray-900 mb-2 line-clamp-2
                           group-hover:text-brand transition-colors duration-300">
                    {{ $article['title'] }}
                </h3>

                {{-- Date --}}
                <span class="text-sm text-gray-500 mb-4">
                    {{ $article['date'] }}
                </span>

                {{-- Read more button --}}
                <span class="mt-auto text-center border border-brand
                             py-3 uppercase text-sm tracking-widest
                             transition duration-300
                             group-hover:bg-brand
                             group-hover:text-white">
                    {!! __('Read more','ws') !!}
                </span>
            </a>
        @endforeach
    </div>
</section>
