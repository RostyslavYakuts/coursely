{{-- Similar Tags --}}
<div class="mt-12 w-full p-4  bg-brand-dark">

    @if($data['similar_tags'])
        <span class="text-2xl text-brand-light-gray block pb-2">
            {!! __('Similar tags','ws') !!}
        </span>
        <div class="flex flex-col gap-3">
            @foreach($data['similar_tags'] as $tag)
                @php
                    $link = get_term_link($tag);
                @endphp
                <a href="{{$link}}"
                   class="transition text-sm text-brand-light-gray rounded hover:underline">
                   #
                    {{$tag->name}} ({{$tag->count}})
                </a>
            @endforeach
        </div>
    @endif
</div>