{{-- Blog Hero --}}
<section class="container mx-auto w-full flex flex-col md:flex-row gap-10">
    <div class="w-full">
        {!! $data['image'] !!}
    </div>

    <div class="w-full flex flex-col gap-6 items-center justify-center px-5">
        <h1 class="uppercase text-4xl">{{$data['h1']}}</h1>
        <div>{!! $data['description'] !!}</div>
    </div>

</section>
