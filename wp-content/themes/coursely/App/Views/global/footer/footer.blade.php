{{-- footer.blade.php   @include('global.footer.google-analytics')--}}
@php
    /**
     * @var array $options
     */
@endphp
<div class="container">
    <div class="footer-banner relative z-20 -mb-[80px] rounded-[40px] py-[80px] w-full flex flex-col justify-center items-center gap-5 ">
        <h2 class="px-5 text-white font-bold text-center text-[32px] lgx:text-[48px] leading-none">{{$options['footer_banner_title']}}</h2>
        <p class="px-5 text-lg text-white text-center">{{$options['footer_banner_description']}}</p>
        <a href="{{$options['footer_banner_cta_link']}}" class="mt-3 bg-white flex justify-center items-center p-3 w-[200px] rounded-full border border-brand-gray text-lg hover:text-white hover:bg-brand-dark">
            {{$options['footer_banner_cta']}}
        </a>
    </div>
</div>

<footer id="footer"  class="w-full pt-[114px] bg-white rounded-tl-[40px] rounded-tr-[40px]">
    <div class="container mx-auto flex flex-col justify-between">
        @include('global.footer.logotype')
        @include('global.footer.footer-contacts')
        @include('global.footer.copyright')
    </div>
</footer>
@php
wp_footer();
@endphp
