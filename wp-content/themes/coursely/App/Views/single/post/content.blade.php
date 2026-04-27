{{-- Post Content --}}
<section class="mx-auto container flex flex-col md:flex-row gap-8 mt-10">

    <div class="w-full md:w-[67%] flex flex-col prose-base">
        <h1 class="text-5xl font-light text-gray-900 tracking-wide mb-6">
            {{ $data['title'] }}
        </h1>
        <span class="flex items-center gap-2">
                <span class="">{!! __('Author','ws') !!}:</span>
                <img width="100" height="100" loading="lazy" decoding="async"
                     class="rounded-full shadow"
                     src="{{$data['author_photo_url']}}" alt=" {{ $data['author_name'] }}">
                <a class="underline font-bold" href="{{$data['author_url']}}">
                    {{ $data['author_name'] }}
                </a>
        </span>
        <div class="w-full flex flex-wrap items-center gap-6 leading-none text-sm">
            <span class="flex items-center gap-1">
                <i class="text-brand fa fa-calendar-plus-o" aria-hidden="true"></i>
                <span class="">{!! __('Published','ws') !!}:</span>
                <time datetime="{{$data['datetime']}}" class="font-bold">
                    {{$data['date']}}
                </time>
            </span>
            <span class="flex items-center gap-1">
                <i class="text-brand fa fa-calendar-check-o" aria-hidden="true"></i>
                <span class="">{!! __('Updated','ws') !!}:</span>
                <time datetime="{{$data['modified_datetime']}}" class="font-bold">
                    {{$data['modified_date']}}
                </time>
            </span>

        </div>
        @if($data['toc'])
        <div class="js-toc_table_list_heading mt-2" aria-label="Table of Contents">
            <h2>{!! __('Table of content','ws') !!}:</h2>
            {!! $data['toc'] !!}
        </div>
        @endif
        <div class="py-[50px]">
            {!! $data['content'] !!}
        </div>

    </div>

    <div class="w-full pb-10 md:w-[32%] flex flex-col gap-6">
        {!! $data['thumbnail'] !!}
        @include('global.social-share',['social'=>$data['social']])
        @include('single.post.category-block',['categories'=>$data['categories']])
        @include('single.post.tag-block',['tags'=>$data['tags']])
    </div>
</section>