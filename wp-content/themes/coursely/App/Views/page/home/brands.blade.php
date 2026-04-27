{{-- Home Brands --}}
<div class="bg-white px-5 w-full py-[100px] flex flex-col items-center justify-center gap-6 text-center text-brand ">
   <h2 class="text-3xl">{{$data['brands_title']}}</h2>
    <p class="w-full text-gray-600 text-lg max-w-2xl mx-auto">{{$data['brands_description']}}</p>
    @if($data['brands'])
    <div class="relative wrap h-[100px] overflow-hidden" id="marquee_slider">
        <div class="list w-full m-0 p-0 absolute flex gap-2" id="list">
            @foreach ($data['brands'] as $item)
                <figure class="slide list__item grow-0 shrink-0 px-5 text-center w-[300px] h-[100px]">
                    <img loading="lazy" decoding="async" src="{{$item['image']['url']}}" alt="{{$item['image']['alt']}}"
                             width="300" height="100" class="object-contain w-[300px] h-[100px]">
                </figure>
            @endforeach
        </div>
    </div>
    @endif
</div>