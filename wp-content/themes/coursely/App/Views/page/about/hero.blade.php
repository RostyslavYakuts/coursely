{{-- About Hero --}}
<section class="w-full container">
    <h1 class="font-bold text-center text-[32px] lgx:text-[48px]  mt-10">
        {{$data['h1']}}
    </h1>
    <p  class="mt-5 text-brand-text text-center text-lg">
        {!! $data['description'] !!}
    </p>

    @if($data['who_we_are'])
        <div class="mt-10 flex flex-col gap-5 lg:gap-10">
            @foreach($data['who_we_are'] as $index => $item)
                @if($index % 2 === 0)
                    @php $tw_class = 'flex-col lg:flex-row-reverse'; @endphp
                @else
                    @php $tw_class = 'flex-col lg:flex-row'; @endphp
                @endif
                <div class="flex {{$tw_class}} gap-5 flex-start min-h-[440px]">
                    <img src="{{$item['image']['url']}}"
                         alt="{{$item['image']['alt']}}"
                         loading="lazy"
                         decoding="async"
                         width="650"
                         height="440"
                         class="brand-shadow rounded-[20px] object-cover w-full h-full "
                    >
                    <div class="p-5 lg:py-8 lgx:px-6 bg-white w-full rounded-[20px] brand-shadow">
                        <strong class="block font-bold text-[24px] ">
                            {{ $item['title'] }}
                        </strong>
                        <div class="mt-5 text-brand-text text-lg flex flex-col gap-2">
                            {!! $item['description']  !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


</section>