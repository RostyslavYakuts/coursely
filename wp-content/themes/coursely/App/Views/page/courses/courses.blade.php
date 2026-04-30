{{-- Courses Page Courses --}}
@php
use coursely\App\Core\Helpers\CourseCard;
    /**
     * @var array $data
     */
    $course_categories = $data['course_categories'];
    if(!$course_categories) return;
    $default_courses = $data['default_courses']['items'];
    if(!$default_courses) return;

@endphp
<section class="w-full container mx-auto">
  <h1 class="font-bold text-center text-brand-dark text-[32px] lgx:text-[48px]  mt-10">
      {{$data['h1']}}
  </h1>

  <div class="course-categories-js mt-5 flex flex-row flex-wrap gap-4 justify-center items-center">
      <div data-id="all" class="active course-tab-js course-category rounded-full text-center lgx:text-lg p-3">
          {{ __('All categories','coursely') }}
      </div>
       @foreach($course_categories as $category)
            <div data-id="{{$category->term_id}}" class="course-tab-js course-category select-none min-w-[100px] rounded-full text-center lgx:text-lg p-3">
                {!! $category->name !!}
            </div>
        @endforeach
  </div>
  <div class="courses-js mt-10 grid grid-cols-1 lgx:grid-cols-3 gap-8">
      @foreach($default_courses as $course)
          {!! CourseCard::render($course) !!}
      @endforeach
  </div>

</section>