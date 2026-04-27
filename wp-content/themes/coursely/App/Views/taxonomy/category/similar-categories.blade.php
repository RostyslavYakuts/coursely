{{-- Similar Categories --}}
<div class="mt-12 w-full p-4 bg-brand-light-gray">

    @if($data['similar_categories'])
        <span class="text-2xl block pb-2">{!! __('Similar categories','ws') !!}</span>
        <div class="flex flex-col gap-3">
            @foreach($data['similar_categories'] as $category)
                @php
                    $link = get_term_link($category);
                @endphp
                <a href="{{$link}}"
                   class="uppercase transition p-3 text-center bg-white text-sm text-brand border border-brand rounded hover:bg-brand hover:text-white">
                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                    {{$category->name}} ({{$category->count}})
                </a>
            @endforeach
        </div>
    @endif
</div>