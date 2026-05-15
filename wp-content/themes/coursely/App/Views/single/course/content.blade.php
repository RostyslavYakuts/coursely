{{-- Course Content --}}
@php

@endphp
<section class="container">
    <div class="couse-hero mt-5 bg-white flex flex-col lgx:flex-row justify-between gap-5 items-center rounded-[40px] brand-shadow p-5 ">
        <div class="py-4 px-5 flex flex-col gap-5">
            @if($data['categories'])
                <div class="categories w-full">
                    @foreach($data['categories'] as $category)
                        <a href="{{$category['link']}}" class="rounded-full text-center bg-[#0158D81A] font-medium py-1.5 px-2.5 ">
                            {{$category['name']}}
                        </a>
                    @endforeach
                </div>
                <h1 class="mt-2.5 font-bold text-[44px] tracking-[0px]">
                    {{$data['title']}}
                </h1>
                <p class="mt-2.5 text-brand-text text-lg max-w-[500px]">
                    {{$data['excerpt']}}
                </p>
                @if($data['rating'])
                <div class="mt-5 rating-wrapper flex flex-row items-center gap-2">
                    @php
                        $rating_int = (int)round($data['rating']);
                    @endphp
                    <div class="rating-stars flex flex-row items-centr gap-1">
                        @for($i = 0; $i <  $rating_int; $i++)
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.03795 14.0193C8.35574 13.8275 8.75363 13.8275 9.07142 14.0193L12.7057 16.2128C13.463 16.6699 14.3972 15.9909 14.1963 15.1295L13.2318 10.9952C13.1475 10.6337 13.2703 10.2553 13.5509 10.0122L16.7633 7.2293C17.4319 6.65009 17.0745 5.55183 16.1931 5.47705L11.9656 5.11839C11.596 5.08703 11.2741 4.85369 11.1294 4.51219L9.47541 0.60978C9.13082 -0.203248 7.97856 -0.20325 7.63397 0.609778L5.98 4.51219C5.83527 4.85369 5.5134 5.08703 5.14382 5.11839L0.916316 5.47705C0.0348899 5.55183 -0.322516 6.65009 0.346082 7.22929L3.55848 10.0122C3.83905 10.2552 3.96189 10.6337 3.87756 10.9952L2.9131 15.1295C2.71214 15.9909 3.64637 16.6699 4.40369 16.2128L8.03795 14.0193Z" fill="#FFB608"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="font-medium text-sm">{{$data['rating']}}</span>
                </div>

                @endif
                <div class="mt-5 flex flex-row gap-8">
                    <div class="flex flex-row items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.30062 0.63904C2.70695 0.229869 3.25805 0 3.83268 0H9.61046C9.80201 0 9.98571 0.0766231 10.1211 0.213013L14.4545 4.57665C14.5899 4.71304 14.666 4.89802 14.666 5.09091V13.8182C14.666 14.3968 14.4377 14.9518 14.0314 15.361C13.6251 15.7701 13.074 16 12.4993 16H3.83268C3.25805 16 2.70695 15.7701 2.30062 15.361C1.89429 14.9518 1.66602 14.3968 1.66602 13.8182V2.18182C1.66602 1.60316 1.89429 1.04821 2.30062 0.63904ZM3.83268 1.45455C3.64114 1.45455 3.45744 1.53117 3.32199 1.66756C3.18655 1.80395 3.11046 1.98893 3.11046 2.18182V13.8182C3.11046 14.0111 3.18655 14.1961 3.32199 14.3324C3.45744 14.4688 3.64114 14.5455 3.83268 14.5455H12.4993C12.6909 14.5455 12.8746 14.4688 13.01 14.3324C13.1455 14.1961 13.2216 14.0111 13.2216 13.8182V5.39216L9.31131 1.45455H3.83268Z" fill="#111230"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.33268 0.666687C9.70087 0.666687 9.99935 0.965164 9.99935 1.33335V4.66669H13.3327C13.7009 4.66669 13.9993 4.96516 13.9993 5.33335C13.9993 5.70154 13.7009 6.00002 13.3327 6.00002H9.33268C8.96449 6.00002 8.66602 5.70154 8.66602 5.33335V1.33335C8.66602 0.965164 8.96449 0.666687 9.33268 0.666687Z" fill="#111230"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.66602 8.66667C4.66602 8.29848 4.96449 8 5.33268 8H10.666C11.0342 8 11.3327 8.29848 11.3327 8.66667C11.3327 9.03486 11.0342 9.33333 10.666 9.33333H5.33268C4.96449 9.33333 4.66602 9.03486 4.66602 8.66667Z" fill="#111230"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.66602 11.3334C4.66602 10.9652 4.96449 10.6667 5.33268 10.6667H10.666C11.0342 10.6667 11.3327 10.9652 11.3327 11.3334C11.3327 11.7015 11.0342 12 10.666 12H5.33268C4.96449 12 4.66602 11.7015 4.66602 11.3334Z" fill="#111230"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.66602 5.99998C4.66602 5.63179 4.96449 5.33331 5.33268 5.33331H6.66602C7.03421 5.33331 7.33268 5.63179 7.33268 5.99998C7.33268 6.36817 7.03421 6.66665 6.66602 6.66665H5.33268C4.96449 6.66665 4.66602 6.36817 4.66602 5.99998Z" fill="#111230"/>
                        </svg>
                        <span>{{$data['lessons_count']}} {{__('lessons','coursely')}}</span>
                    </div>
                    <div class="flex flex-row items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_403_6637)">
                                <circle cx="8" cy="8" r="7.25" stroke="#111230" stroke-width="1.5"/>
                                <path d="M8 4.44446V8.56799L10.6667 9.77779" stroke="#111230" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_403_6637">
                                    <rect width="16" height="16" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                        <span>{{$data['duration']}}</span>
                    </div>
                </div>

            @endif

        </div>
       {!! $data['thumbnail'] !!}
    </div>
    <div class="lgx:px-8 content gap-5 flex flex-col lgx:flex-row items-start ">
        <div class="gutenberg-content prose prose-base w-full flex flex-col gap-0">
            {!! $data['content'] !!}
            @include('single.course.modules')
        </div>
        @include('single.course.subscribe-banner')
    </div>
</section>