{{-- Courses User Courses Flter --}}
@if($data['user_course_filter_items'])
<div class="user-courses-filter-items my-8 flex flex-col px-6 py-5 rounded-[20px] bg-white brand-shadow ">
   <div class="flex flex-col mdx:flex-row gap-5 ">
      @foreach($data['user_course_filter_items'] as $key => $item)
         <div class="user-courses-filter-item py-2 mdx:pt-3 mdx:pb-5 text-lg font-bold {{$key === 0 ? 'active' : ''}} cursor-pointer" data-filter="{{ $item['data_name'] ?? '' }}" data-value="{{ $item['value'] }}">
            {{ $item['title'] }}
            <span class="count">
            ({{ $item['value'] }})
         </span>
         </div>
      @endforeach
   </div>
   <div class="hidden mdx:block w-full h-[1px] bg-gray"></div>

</div>
@endif