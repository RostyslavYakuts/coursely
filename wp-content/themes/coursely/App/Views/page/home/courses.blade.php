{{-- Home Courses --}}
@php
use coursely\App\Core\Helpers\CourseCard;
    /**
     * @var array $data
     */
    $course_categories = $data['course_categories'];
    if(!$course_categories) return;
    $default_courses = $data['default_courses'];
    if(!$default_courses) return;
@endphp
<section class="w-full container mx-auto">
  <h2 class="text-center text-brand-dark text-[32px] lgx:text-[48px]  mt-[120px]">
      {{$data['courses_section_title']}}
  </h2>

  <div class="course-categories-js mt-5 flex flex-row flex-wrap gap-4 justify-center items-center">
      <div data-id="all" class="active course-tab-js course-category rounded-full text-center lgx:text-lg p-3 lgx:p-4 ">
          {{ __('All categories','coursely') }}
      </div>
       @foreach($course_categories as $category)
            <div data-id="{{$category->term_id}}" class="course-tab-js course-category select-none min-w-[100px] rounded-full text-center lgx:text-lg p-3 lgx:p-4">
                {!! $category->name !!}
            </div>
        @endforeach
  </div>
  <div class="courses-js mt-10 grid grid-cols-1 lgx:grid-cols-3 gap-8">
      @foreach($default_courses as $course)
          {!! CourseCard::render($course) !!}
      @endforeach
  </div>

  <a href="{{$data['courses_section_cta_link']}}" class="mt-10 mx-auto w-full lgx:max-w-[250px] flex items-center justify-center brand-btn-dark">
      {{$data['courses_section_cta']}}
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M13.1667 6L19 12M19 12L13.1667 18M19 12L5 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
  </a>

</section>