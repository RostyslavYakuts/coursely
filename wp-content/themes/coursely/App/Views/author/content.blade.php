{{-- Author Content --}}
{{-- Author Content --}}
<section class="container mx-auto py-[120px] px-4">
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-xl p-10 flex flex-col lg:flex-row gap-10">

        {{-- Photo --}}
        <div class="flex-shrink-0 w-full lg:w-1/3">
            <img src="{{ $data['author_photo']['url'] }}"
                 alt="{{ $data['full_name'] }}"
                 class="rounded-full w-full h-auto object-cover shadow-xl transition-transform duration-500 hover:scale-105">
        </div>

        {{-- Content --}}
        <div class="lg:w-2/3 flex flex-col gap-6">
            {{-- Name --}}
            <h1 class="text-5xl font-extralight text-gray-900 tracking-wide">
                {{ $data['full_name'] }}
            </h1>

            {{-- Description --}}
            <p class="text-lg text-gray-700 leading-relaxed">
                {{ $data['description'] }}
            </p>

            {{-- About Author (rich text) --}}
            <div class="prose prose-lg text-gray-800 max-w-none">
                {!! $data['about_author'] !!}
            </div>
        </div>
    </div>
</section>


