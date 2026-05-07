{{-- Course Content --}}
@php

@endphp
<section class="container">
    <div class="couse-hero mt-5 bg-white flex flex-col lgx:flex-row justify-between gap-5 items-center rounded-[40px] brand-shadow p-5 ">
        <div class="py-4 px-5 flex flex-col gap-5">
            @if($data['categories'])
                <div class="w-full">
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
    <div class="px-8 content gap-5 flex flex-col lgx:flex-row items-start ">
        <div class="gutenberg-content prose prose-base w-full flex flex-col gap-0">
            {!! $data['content'] !!}
            @include('single.course.modules')
        </div>
        <div class="subscribe-banner w-full lgx:w-[406px] lgx:min-w-[406px] lgx:h-[365px] mt-14 bg-white rounded-[20px] brand-shadow p-5 lgx:py-8 lgx:px-6 flex flex-col">
            <h3 class="leading-none font-bold text-[24px]">{{__('Subscribe and Save','coursely')}}</h3>
            <div class="mt-8 flex w-full justify-between items-end">
                <span>{{__('Starting at','coursely')}}</span>
                <span><b class="leading-none text-[36px]">{{$data['month_plan']}}</b>
                    <span class="text-brand-text">/{{__('month','coursely')}}</span></span>
            </div>
            @if($data['subscribe_features'])
            <ul class="mt-8 flex flex-col gap-4">
                @foreach($data['subscribe_features'] as $feature)
                <li class="leading-none flex flex-row gap-2 items-center text-lg text-brand-text">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 0C7.21997 0 5.47991 0.527841 3.99987 1.51677C2.51983 2.50571 1.36628 3.91131 0.685088 5.55585C0.00389957 7.20038 -0.17433 9.00998 0.172937 10.7558C0.520203 12.5016 1.37737 14.1053 2.63604 15.364C3.89472 16.6226 5.49836 17.4798 7.24419 17.8271C8.99002 18.1743 10.7996 17.9961 12.4442 17.3149C14.0887 16.6337 15.4943 15.4802 16.4832 14.0001C17.4722 12.5201 18 10.78 18 9C18 6.61305 17.0518 4.32387 15.364 2.63604C13.6761 0.948212 11.387 0 9 0ZM13.23 6.46L8.79 12.62C8.65775 12.7985 8.46474 12.9225 8.24737 12.9686C8.03001 13.0146 7.8033 12.9796 7.61 12.87L5.06 11.38C4.85314 11.2553 4.70426 11.0536 4.64612 10.8192C4.58798 10.5848 4.62535 10.3369 4.75 10.13C4.87466 9.92313 5.07638 9.77425 5.3108 9.71612C5.54522 9.65798 5.79314 9.69535 6 9.82L7.81 10.9L11.81 5.41C11.9585 5.26128 12.1543 5.16919 12.3635 5.1497C12.5727 5.13021 12.7822 5.18454 12.9556 5.30329C13.1289 5.42204 13.2553 5.5977 13.3127 5.79984C13.3701 6.00198 13.355 6.21784 13.27 6.41L13.23 6.46Z" fill="#1C55E0"/>
                    </svg>
                    {{$feature}}
                </li>
                @endforeach
            </ul>
            @endif
            <a href="{{$data['activate_subscription_link']}}" class="mt-8 mx-auto w-full flex items-center justify-center brand-btn-dark">
                {{__('Activate subscription','coursely')}}
            </a>
        </div>
    </div>
</section>