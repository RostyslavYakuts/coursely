{{-- Courses Page FAQ --}}
<section class="my-[120px]">
    <div class="container mx-auto">
        <h2 class="text-center text-brand-dark text-[32px] lgx:text-[48px] ">
            {{$data['faq_title']}}
        </h2>
        <p class="mt-5 text-lg text-brand-text text-center">
            {{$data['faq_description']}}
        </p>

        @include('global.faq')

    </div>

</section>