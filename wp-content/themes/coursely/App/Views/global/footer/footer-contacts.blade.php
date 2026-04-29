{{-- Footer Contacts --}}
<div class="flex flex-col gap-[40px] l:gap-0 l:flex-row justify-between items-start mt-6">
    @php
        wp_nav_menu([
            'theme_location' => 'footer_menu',
            'menu_class' => '[&_a:hover]:underline footer-menu flex items-center text-sm gap-4',
            'container' => false,
        ]);
    @endphp

    <div class="flex flex-col gap-5">
        <span class="font-bold text-lg">{{$options['footer_contacts_text']}}</span>
        <span class="flex flex-row gap-3">
            <a class="underline font-medium" href="tel:{{$options['admin_phone']}}">{{$options['admin_phone']}}</a>
            <a class="underline font-medium" href="mailto:{{$options['admin_email']}}">{{$options['admin_email']}}</a>
        </span>
    </div>

</div>
