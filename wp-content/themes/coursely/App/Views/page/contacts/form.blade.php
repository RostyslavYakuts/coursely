{{-- Form --}}
@php
    /**
     * @var array $data
     */
@endphp

<section class="container">
    @include('global.form-modal',['data'=>['id'=>'contact_us_modal']])
    <div class="bg-white rounded-[40px] mt-10 brand-shadow p-5 lgx:p-6 w-full grid grid-cols-1 lgx:grid-cols-2 gap-10">
        <img width="600" height="610" loading="lazy" decoding="async"
             class="object-cover rounded-[20px] w-full h-full max-h-[610px]"
             src="{{$data['background_image_url']}}" alt="">
        <div class="flex flex-col gap-6 relative">
            <span class="font-bold text-[32px] ">{!! __('Send us a message!','coursely') !!}</span>

            <form autocomplete="off" id="contact_us_form" class="contact-us-form flex flex-col gap-6 w-full max-w-[624px]" method="post">

                <div class="relative flex flex-col gap-1">
                    <label class="font-medium" for="user_name">{!! __('Full Name','coursely') !!}<span class="text-brand">*</span></label>
                    <input placeholder="{{__('Enter first and last name','coursely')}}" class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" type="text" name="user_name" id="user_name">
                    <span class="text-error font-semibold text-xs xs:text-sm hidden contacts-error-js" id="user_name_error"></span>
                </div>
                <input class="hidden" type="text" id="user_company" name="user_company" autocomplete="off">
                <div class="relative flex flex-col gap-1">
                    <label class="font-medium" for="user_email">{!! __('Email','coursely') !!}<span class="text-brand">*</span></label>
                    <input placeholder="{{__('Enter email address','coursely')}}" class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" type="email" name="user_email" id="user_email">
                    <span class="text-error font-semibold text-xs xs:text-sm hidden contacts-error-js" id="user_email_error"></span>
                </div>
                <div class="relative flex flex-col gap-1">
                    <label class="font-medium" for="user_subject">{!! __('Subject','coursely') !!}<span class="text-brand">*</span></label>
                    <input placeholder="{{__('Enter subject','coursely')}}" class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" type="text" name="user_subject" id="user_subject">
                    <span class="text-error font-semibold text-xs xs:text-sm hidden contacts-error-js" id="user_subject_error"></span>
                </div>
                <div class="relative flex flex-col gap-1">
                    <label class="font-medium" for="user_message">{!! __('Message','coursely') !!}</label>
                    <textarea placeholder="{{__('Enter message','coursely')}}" class="form-input active:border-brand resize-none h-[104px] bg-transparent rounded-lg py-[10px] px-[12px] border border-gray" name="user_message" id="user_message"></textarea>
                    <span class="text-error font-semibold text-xs xs:text-sm hidden contacts-error-js" id="user_message_error"></span>
                </div>

                <button class="mt-10 mx-auto w-full flex items-center justify-center brand-btn-dark">
                    {{__('Send Message','coursely')}}
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.1667 6L19 12M19 12L13.1667 18M19 12L5 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

</section>



