{{-- Recommended Services --}}
@php
    /**
    * @var array $data
    */
    if(!$data['recommended']) return;
@endphp
<div class="container mx-auto py-[100px]">

    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold tracking-wide mb-4">
            {!! __('Recommended Services','ws') !!}
        </h2>
        <p class="text-gray-500 max-w-2xl mx-auto">
            {!! __('Explore other services that can help improve performance, stability and growth of your website.','ws') !!}
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">

        @foreach($data['recommended'] as $service)
            <a href="{{ $service['link'] }}"
               class="group block bg-white rounded-xl overflow-hidden border border-gray-200
           hover:shadow-2xl transition-all duration-300">

                <div class="overflow-hidden">
                    {!! $service['thumbnail'] !!}
                </div>

                <div class="p-6">

                    <h3 class="text-xl font-semibold mb-3 group-hover:text-brand-accent transition-colors">
                        {{ $service['title'] }}
                    </h3>

                    <div class="flex items-center text-sm font-semibold text-brand-accent">
                        {!! __('Learn more','ws') !!}
                        <span class="ml-2 transform group-hover:translate-x-1 transition">
                        →
                    </span>
                    </div>

                </div>

            </a>
        @endforeach

    </div>

</div>
