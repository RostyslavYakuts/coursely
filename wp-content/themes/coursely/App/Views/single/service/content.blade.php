{{-- Service Content --}}
<section class="mx-auto container flex flex-col md:flex-row gap-8 mt-10">

    <div class="w-full md:w-[67%] flex flex-col prose-base">
        <h1 class="text-5xl font-light text-gray-900 tracking-wide mb-6">
            {{ $data['title'] }}
        </h1>

        <div class="js-toc_table_list_heading mt-2" aria-label="Table of Contents">
            <h2>{!! __('Table of content','ws') !!}:</h2>
            {!! $data['toc'] !!}
        </div>
        <div class="py-[50px] prose-base">
            {!! $data['content'] !!}
        </div>

    </div>

    <div class="w-full md:w-[32%] flex flex-col gap-6">
        {!! $data['thumbnail'] !!}
        @include('global.social-share',['social'=>$data['social']])
    </div>
</section>