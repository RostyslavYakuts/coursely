{{-- Global Service --}}

<a href="{{$link}}" class="service xl:max-w-[424px] bg-white w-full rounded-[20px] flex flex-col gap-4 justify-between hover:shadow-2xl py-[26px] px-[20px] md:px-[32px]">
    <div class="flex flex-col gap-4">
        <div class="flex flex-row gap-4 items-center">
            {!! $thumbnail !!}
            <h3 class="text-brand-header text-[24px]">{!! $title !!}</h3>
        </div>
        <p class="excerpt text-brand-text">{!! $excerpt !!}</p>
    </div>

    @include('global.learn-more',['data'=>[
          'button_tag'=>'span'
      ]])
</a>