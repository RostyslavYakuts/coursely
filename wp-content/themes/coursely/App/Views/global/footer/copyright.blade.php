{{-- Copyright --}}
<div class="w-full flex flex-col-reverse gap-6 smx:flex-row justify-between items-center">
	<div class="copyright text-sm text-white">
		© {{ date("Y") }}, coursely.COM - All rights reserved.
	</div>

	@php
            wp_nav_menu([
                'theme_location' => 'footer_menu',
                'menu_class' => '[&_a:hover]:underline footer-menu flex items-center gap-2 text-sm text-white',
                'container' => false,
            ]);
	@endphp
</div>
