@php
 $href = home_url();
@endphp
@if(isset($options['header_logo']))

	<a class="relative z-20" aria-label="logo" href="{{ $href  }}">
		<img width="140"
			 height="44"
			 class="h-auto"
			 src="{{ $options['header_logo']['url'] ?? '' }}"
			 alt="{{ $options['header_logo']['alt'] ?? '' }}">
	</a>

@endif
