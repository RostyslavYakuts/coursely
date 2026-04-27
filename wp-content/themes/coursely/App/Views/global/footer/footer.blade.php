{{-- footer.blade.php   @include('global.footer.google-analytics')--}}
@php
    /**
     * @var array $options
     */
@endphp
<footer id="footer"  class="w-full bg-brand-dark text-white py-[60px]">
    <div class="container mx-auto flex flex-col justify-between gap-[60px]">
        @include('global.footer.logotype')
        @include('global.footer.footer-contacts')
        @include('global.footer.copyright')
    </div>
</footer>
@php
wp_footer();
@endphp
