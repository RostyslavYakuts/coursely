{{-- Home Statistic --}}
<div class="w-full bg-white">
    <section id="statistic" class="container mx-auto py-[60px]">
        <div class="flex flex-col gap-6 mdx:flex-row justify-between items-start">
            <h2 class="text-3xl w-full text-brand-gold">
                {!! $data['statistic_section_title'] !!}
            </h2>
            @if($data['statistic_section_marks'])
                <div class="w-full flex flex-col smx:flex-row justify-between items-start smx:items-center">
                    @foreach($data['statistic_section_marks'] as $mark)
                        <div class="flex flex-col gap-3 text-brand-gold">
                            <b data-statistic="{{$mark['mark']}}" class="animate-number-js text-4xl"></b>
                            <span class="uppercase">{{$mark['title']}}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </section>
</div>
