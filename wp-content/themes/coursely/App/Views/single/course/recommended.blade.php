{{-- Recommended Courses --}}
@php
    /**
    * @var array $data
    */
    use coursely\App\Core\Helpers\CourseCard;
    if(!$data['recommended']) return;
@endphp
<div class="container mx-auto py-[100px]">

    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold tracking-wide mb-4">
            {!! __('Courses You might be interested in','coursely') !!}
        </h2>
    </div>

    <div class="courses-js mt-10 grid grid-cols-1 lgx:grid-cols-3 gap-8">
        @foreach($data['recommended'] as $course)
            {!! CourseCard::render($course) !!}
        @endforeach
    </div>

</div>
