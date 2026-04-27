{{-- Logotype template part --}}
@if ($options)
	<div class="flex justify-between items-center">
		<div class="max-w-[170px] flex flex-col gap-3 items-center justify-center">
			<img decoding="async" loading="lazy" width="184" height="46" src="{{ $options['logo']['url'] ?? '' }}" alt="{{ $options['logo']['alt'] ?? '' }}">
			<span class="font-bold text-2xl">
				<span class="text-white uppercase">coursely</span><span class="text-brand-accent">studio</span>
			</span>
		</div>
		<button aria-label="Move Up" type="button" class="rounded-full p-4 bg-brand-accent hover:bg-brand-gray scroll-to-top-js">
			<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
				<g clip-path="url(#clip0_154_1584)">
					<path d="M13.6687 27.8495L14.6912 27.8503L14.6912 1.96114L22.5624 9.83227L23.2864 9.10821L14.1804 0.0021274L5.07329 9.10724L5.79728 9.83123L13.6674 1.96114L13.6687 27.8495Z" fill="#fff"/>
				</g>
				<defs>
					<clipPath id="clip0_154_1584">
						<rect width="20.0542" height="20.0542" fill="#fff" transform="translate(28.3611 14.1807) rotate(135)"/>
					</clipPath>
				</defs>
			</svg>
		</button>

	</div>


@endif
