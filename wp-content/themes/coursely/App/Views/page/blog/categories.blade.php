{{-- Categories Blog --}}

<div class="min-w-[250px] ">
    @if($data['categories'])
        <ul class="categories py-2 pl-2 text-brand">
            @foreach($data['categories'] as $category)
                <li>
                    <a href="{{get_term_link($category->term_id)}}" class="font-bold hover:underline">
                        {{$category->name}} ({{$category->count}})
                    </a>
                </li>
            @endforeach
        </ul>
        <ul class="tags py-2 pl-2 text-brand">
            @foreach($data['tags'] as $tag)
                <li>
                    <a href="{{get_term_link($tag->term_id)}}" class="hover:underline">
                       #{{$tag->name}} ({{$tag->count}})
                    </a>
                </li>
            @endforeach
        </ul>

    @endif
</div>