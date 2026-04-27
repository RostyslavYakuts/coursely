{{-- Hero section --}}
<section id="hero_section"  class="home-hero-section rounded-[40px] -mt-[84px] relative w-full hero-section default home-hero-section flex flex-col justify-center items-center gap-[32px]">

    <div class="flex items-center gap-2 p-2 w-[300px] mx-auto mt-[164px] rounded-full bg-[#FFFFFF22] border border-[#FFFFFF33]">
        <img src="{{$data['trusted_by_image']['url']}}" alt="{{$data['trusted_by_image']['alt']}}">
        <span class="text-white">{{$data['trusted_by']}}</span>
    </div>
    <h1 class="text-white text-[80px] max-w-[950px] text-center">{{$data['h1']}}</h1>
    <p class="max-w-[758px] text-lg text-center text-white">{{$data['description']}}</p>
    <div class="flex flex-row gap-2 items-center">
        <a href="{{$data['cta_link']}}" class="px-4 w-[200px] brand-btn h-[52px] text-brand-dark  hover:bg-brand-dark hover:text-white bg-white">
            {{$data['cta_text']}}
        </a>
        <a href="{{$data['cta_2_link']}}" class="px-4 w-[200px] brand-btn h-[52px] text-white bg-[#FFFFFF22] hover:bg-brand border border-[#FFFFFF33]">
            {{$data['cta_2_text']}}
        </a>
    </div>
    <div class="mt-[80px] mb-[80px] rounded-[20px] bg-[#FFFFFF22] w-full h-[118px] max-w-[875px]">

    </div>
</section>


