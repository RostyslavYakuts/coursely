{{-- Cases Home --}}
@php
    /**
    * @var array $data
    */
    if(!$data['why_section_arguments']) return;
@endphp
<section class="bg-[#0158D81A] w-full mt-[120px] rounded-[20px] lgx:rounded-[40px] lgx:px-5 pt-10 pb-14">
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <h2 class="text-brand-dark text-[32px] lgx:text-[48px] ">{{$data['why_section_title']}}</h2>
            <a href="{{$data['why_section_cta_link']}}" class="hidden lgx:flex items-center justify-center w-full lgx:max-w-[250px] brand-btn-dark">
                {{$data['why_section_cta']}}
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.1667 6L19 12M19 12L13.1667 18M19 12L5 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

        <div class="mt-10 grid grid-cols-1 lgx:grid-cols-2 gap-10">

            <div class="arguments w-full flex flex-col gap-5">
                @foreach($data['why_section_arguments'] as $argument)
                    <div class="rounded-[20px] bg-white p-5 lgx:py-[26px] lgx:px-[24px] flex flex-row items-start gap-5 lgx:gap-8 brand-shadow">
                        <img src="{{$argument['image']['url']}}" alt="{{$argument['image']['alt']}}" width="40" height="40" class="w-[32px] h-[32px] lgx:w-[40px] lgx:h-[40px]">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-brand-dark text-[20px] lgx:text-[24px] font-bold">{{$argument['title']}}</h3>
                            <p class="text-brand-text lgx:lg">{{$argument['description']}}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <img src="{{$data['why_section_image']['url']}}"
                     alt="{{$data['why_section_image']['alt']}}"
                     loading="lazy" decoding="async" width="640" height="487"
                     class="rounded-[20px] object-cover w-full h-full brand-shadow"
            >

            <a href="{{$data['why_section_cta_link']}}" class="mt-8 flex lgx:hidden items-center justify-center w-full lgx:max-w-[250px] brand-btn-dark">
                {{$data['why_section_cta']}}
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.1667 6L19 12M19 12L13.1667 18M19 12L5 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>

        </div>

    </div>
</section>