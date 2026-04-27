{{-- Recently viewed Product --}}
@if($data['recommended'])
<div class="container mx-auto py-[50px]">

    <h2 class="text-3xl font-light text-center mb-14 tracking-wide">
        Рекомендуємо для Вас
    </h2>

    <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        @foreach($data['recommended'] as $item)
            @php
                $product_id = $item['product'];
                $product = wc_get_product($product_id);
                if (!$product) continue;

                $image_id = $product->get_image_id();
                $image = wp_get_attachment_image_url($image_id, 'medium');
                $rating = 20 * (int)$product->get_average_rating();
            @endphp

            <a href="{{ get_permalink($product_id) }}"
               class="group bg-white rounded-xl p-6 flex flex-col
                      transition duration-500
                      hover:shadow-2xl hover:-translate-y-2">

                    {{-- image --}}
                    <div class="overflow-hidden mb-6">
                        <img
                                src="{{ $image }}"
                                alt="{{ $product->get_name() }}"
                                class="w-full h-[240px] object-contain
                                                   transition duration-700
                                                   group-hover:scale-105"
                        >
                    </div>

                    {{-- title --}}
                    <h3 class="text-center text-lg font-medium
                               tracking-wide mb-3
                               group-hover:text-brand transition">
                        {{ $product->get_name() }}
                    </h3>

                    {{-- rating --}}
                    <div class="flex justify-center mb-3">
                        @include('global.star-rating',['rating'=>$rating])
                    </div>

                    {{-- price --}}
                    <div class="text-center mb-6">
                        <span class="text-xl font-light text-black">
                            {!! $product->get_price_html() !!}
                        </span>
                    </div>

                    {{-- button --}}
                    <span class="mt-auto text-center border border-brand rounded
                                                 py-3 uppercase text-sm tracking-widest
                                                 transition duration-300
                                                 group-hover:bg-brand
                                                 group-hover:text-white">
                                       Переглянути
                    </span>

            </a>
  @endforeach
    </div>

</div>
@endif