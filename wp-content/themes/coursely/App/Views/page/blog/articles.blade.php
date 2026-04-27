{{-- Articles Blog --}}
<section class="w-full flex flex-col py-[50px]">
    <div class="w-full bg-brand py-6">
        <div class="container mx-auto text-white flex flex-col md:flex-row gap-6 justify-between items-center">
            <h2 class="text-3xl">{{$data['all_articles_section_title']}}</h2>
            <p class="max-w-[600px] mx-auto">{{$data['all_articles_section_description']}}</p>
        </div>
    </div>



    <div class="mt-10 container mx-auto flex flex-col xs:flex-row gap-6 justify-between items-start ">
        @include('page.blog.all-posts')
        @include('page.blog.categories')
    </div>
</section>