{{-- Logotype template part --}}
@if ($options)
	<div class="flex justify-between items-center">
		<div class="max-w-[170px] flex flex-col gap-3 items-center justify-center">
			<img decoding="async" loading="lazy" width="184" height="46" src="{{ $options['logo']['url'] ?? '' }}" alt="{{ $options['logo']['alt'] ?? '' }}">
		</div>
	</div>
@endif
