{{-- Form --}}
@php
    /**
     * @var array $data
     */
@endphp


@include('global.form-modal',['data'=>['id'=>'contact_us_modal']])
        <div class="mt-5 mb-12 mx-auto p-5 w-full max-w-[700px]">
            <div class="flex flex-col gap-6 relative">
                <span>{!! __('Please, fill in the fields','ws') !!}</span>

                <form autocomplete="off" id="contact_us_form" class="contact-us-form flex flex-col gap-6 w-full max-w-[624px]" method="post">

                    <div class="relative flex flex-col gap-1">
                        <label for="user_name">{!! __('Your Name','ws') !!}*</label>
                        <input class="bg-transparent active:border-brand h-[50px] py-[13px] px-[22px] border border-light-gray" type="text" name="user_name" id="user_name">
                        <span class="text-error font-semibold text-xs xs:text-sm hidden contacts-error-js" id="user_name_error"></span>
                    </div>
						  <input type="text" id="company" name="company" autocomplete="off">
                    <div class="relative flex flex-col gap-1">
                        <label for="user_email">{!! __('Email','ws') !!}*</label>
                        <input class="bg-transparent form-input active:border-brand h-[50px] py-[13px] px-[22px] border border-light-gray" type="email" name="user_email" id="user_email">
                        <span class="text-error font-semibold text-xs xs:text-sm hidden contacts-error-js" id="user_email_error"></span>
                    </div>
                    <div class="relative flex flex-col gap-1">
                        <label for="user_message">{!! __('Message','ws') !!}</label>
                        <textarea class="bg-white form-input active:border-brand resize-none h-[104px] py-[13px] px-[22px] border border-light-gray" name="user_message" id="user_message"></textarea>
                        <span class="text-error font-semibold text-xs xs:text-sm hidden contacts-error-js" id="user_message_error"></span>
                    </div>
                    <div class="relative flex flex-col gap-1">
                        <span class="pseudo-label">{!! __('Upload your file','ws') !!} (TXT, DOC, JPG, PNG, PDF)</span>
                        <label for="user_file" class="relative pseudo-placeholder cursor-pointer bg-transparent form-input h-[50px] py-[13px] px-[22px] border border-light-gray flex items-center justify-between">
                            <span class="file-placeholder-js cursor-pointer">{!! __('Select','ws') !!}</span>
                            <input class="opacity-0 absolute max-w-full w-full h-full left-0 top-0 z-10 cursor-pointer" type="file" name="user_file" id="user_file">
                        </label>
                        <span class="text-error font-semibold text-xs xs:text-sm hidden file-error-js" id="user_file_error"></span>


                    </div>

                    @include('global.brand-btn',[
                       'data'=>[
                           'aria_label'=>__('Submit form','ws'),
                           'button_tag'=>'button',
                           'type'=>'submit',
                           'tw_classes'=>'text-white hover:text-brand-accent',
                           'button_title'=>__('Submit','ws') ,
                       ]
                       ])
                </form>
            </div>
        </div>



