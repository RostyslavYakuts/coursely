{{-- Pricing Page Plans --}}
<section class="w-full container mx-auto">
    <h1 class="font-bold text-center text-brand-dark text-[32px] lgx:text-[48px]  mt-10">
        {{$data['h1']}}
    </h1>
    <p class="mt-5 text-lg text-brand-text text-center">
        {{$data['description']}}
    </p>
    @include('global.pricing')
</section>