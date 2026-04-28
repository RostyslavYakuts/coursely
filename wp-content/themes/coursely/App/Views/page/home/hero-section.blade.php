{{-- Hero section --}}
<section id="hero_section"  class="home-hero-section rounded-bl-[40px] rounded-br-[40px] -mt-[84px] relative w-full hero-section default home-hero-section flex flex-col justify-center items-center gap-[32px]">

    <div class="flex items-center gap-2 p-2 w-[300px] mx-auto mt-[132px] lgx:mt-[164px] rounded-full bg-[#FFFFFF22] border border-[#FFFFFF33]">
        <img src="{{$data['trusted_by_image']['url']}}" alt="{{$data['trusted_by_image']['alt']}}">
        <span class="text-white">{{$data['trusted_by']}}</span>
    </div>
    <h1 class="font-bold text-white text-[48px] lgx:text-[80px] max-w-[950px] text-center">{{$data['h1']}}</h1>
    <p class="-mt-[12px] lgx:mt-0 max-w-[350px] lg:max-w-[758px] lgx:text-lg text-center text-white">{{$data['description']}}</p>
    <div class="flex flex-row gap-2 items-center">
        <a href="{{$data['cta_link']}}" class="px-4 w-[171px] lgx:w-[200px] brand-btn h-[52px] text-brand-dark  hover:bg-brand-dark hover:text-white bg-white">
            {{$data['cta_text']}}
        </a>
        <a href="{{$data['cta_2_link']}}" class="px-4 w-[171px] lgx:w-[200px] brand-btn h-[52px] text-white bg-[#FFFFFF22] hover:bg-brand border border-[#FFFFFF33]">
            {{$data['cta_2_text']}}
        </a>
    </div>
    <div class="mt-[80px] mb-[24px] lgx:mb-[80px] rounded-[20px] bg-[#FFFFFF22] w-full  h-[98px] lgx:h-[118px] max-w-[350px] lgx:max-w-[875px]">
        @if($data['statistic_section_marks'])
            <div class="w-full h-[98px] lgx:h-[118px] flex gap-5 lgx:gap-10 flex-row justify-center items-center">
                @foreach($data['statistic_section_marks'] as $key => $mark)
                    <div class="w-[184px] flex flex-col justify-center items-center gap-2 text-brand-gold">
                        <b class="text-white text-[24px] lgx:text-[36px]">{{$mark['mark']}}<span class="text-brand">+</span></b>
                        <span class="text-white text-sm lgx:text-lg">{{$mark['title']}}</span>
                    </div>
                    @if( ($key + 1) < count($data['statistic_section_marks']) )
                        <div class="h-[52px] w-[1px] bg-gray"></div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>


