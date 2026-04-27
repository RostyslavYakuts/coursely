{{-- Product Category Top Info --}}
<section class="container mx-auto mt-5 flex flex-col md:flex-row items-start gap-10">
    <div class="w-full md:w-[32%]">
        <img class="w-full h-auto max-w-[500px]"
             src="{{$data['image']['url']}}"
             alt="{{$data['name']}}"
             loading="lazy"
             decoding="async" width="500" height="300">
        @include('taxonomy.category.similar-categories')
    </div>
    <div class="w-full md:[w-67%] mt-4 flex flex-col gap-10">
        <h1 class="text-4xl uppercase">{{$data['name']}}</h1>
        <div class="flex flex-col gap-6">
            {!! $data['description'] !!}
        </div>
    </div>
</section>