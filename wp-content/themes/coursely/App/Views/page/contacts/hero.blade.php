{{-- Hero Contacts --}}
<section class="w-full h-calc-100-100 relative mt-[100px]">
    <img class="absolute top-0 left-0 w-full h-full object-cover"
         decoding="async" loading="lazy"
         src="{{$data['background_image_url']}}" alt="Contacts">
    <div class="px-5 absolute bg-half-black top-0 left-0 z-10 w-full h-full flex flex-col gap-6 justify-center items-center text-center text-white">
        <h1 class="text-4xl">{{$data['h1']}}</h1>
        <p class="w-full max-w-[700px]">{{$data['short_description']}}</p>
    </div>
</section>