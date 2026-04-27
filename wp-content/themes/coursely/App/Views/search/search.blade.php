{{-- Search --}}
@extends('layout')

@section('content')
    @include('global.breadcrumbs',['wrapper'=>true])

    <section class="container mx-auto py-[50px]">
        <h1 class="text-4xl font-bold mb-8 text-gray-900">{!! __('Search result','ws') !!}: "{{ $data['query'] }}"</h1>

        @if($data['posts']->have_posts())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @while($data['posts']->have_posts())
                    @php
                     $data['posts']->the_post();
                     $postType = get_post_type();
                     $postName = __('Article','ws');
                     if($postType === 'service'){
                        $postName = __('Service','ws');
                     }
                    @endphp

                    <a href="{{ get_permalink() }}" class="group block bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                        @if(has_post_thumbnail())
                            <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'medium') }}"
                                 alt="{{ get_the_title() }}"
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                            </div>
                        @endif

                        <div class="p-4 flex flex-col justify-between h-[180px]">
                            <h2 class="text-lg font-semibold text-gray-900 line-clamp-3 mb-2 group-hover:text-brand transition-colors duration-300">
                                {{ get_the_title() }}
                            </h2>

                            <div class="text-sm text-gray-500 flex justify-between items-center">
                                <span>{{ get_the_date('F d, Y') }}</span>
                                <span class="uppercase bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">{{ $postName }}</span>
                            </div>
                        </div>
                    </a>

                @endwhile
            </div>

            {{-- Pagination --}}
           <div class="mt-12 w-full flex justify-center items-center max-w-[250px]">
               @php
               echo '<style>
                .page-numbers{
               display:flex;
               justify-content: space-between;
                align-items:center;
                 gap:10px;
                 }</style>';
                   the_posts_pagination([
                       'mid_size'  => 2,
                       'prev_text' => __('«', 'di'),
                       'next_text' => __('»', 'di'),
                       'screen_reader_text' => 'Pagination',
                       'type' => 'list',
                   ]);
               @endphp
           </div>

            @php wp_reset_postdata(); @endphp
        @else
            <p class="text-gray-600 text-lg mt-10">
                {!! __('Nothing found','ws') !!}
            </p>
        @endif
    </section>
@endsection