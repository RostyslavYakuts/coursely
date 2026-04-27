{{-- Sign Up --}}

<form id="signup_form" class="auth-form-js w-full max-w-[492px] hidden" method="post">
    <span class="h3 font-bold text-[32px]">{{__('Sign Up','coursely')}}</span>
    <fieldset class="mt-5 flex flex-col gap-1">
        <label for="signup_user_name">{{__('Full Name','coursely')}}
            <span class="text-brand">*</span>
        </label>
        <input class="w-full border border-gray text-brand-light-gray py-2.5 px-3 rounded-lg" type="text" placeholder="{{__('Enter First and Last name','coursely')}}" id="signup_user_name" name="signup_user_name">
        <span id="signup_user_name_error" class="error text-sm"></span>
    </fieldset>
    <fieldset class="mt-5 flex flex-col gap-1">
        <label for="signup_user_email" class="font-medium">
            {{__('Email address','coursely')}}
            <span class="text-brand">*</span>
        </label>
        <input class="w-full border border-gray text-brand-light-gray py-2.5 px-3 rounded-lg" type="email" placeholder="{{__('Enter email address','coursely')}}" id="signup_user_email" name="signup_user_email">
        <span id="signup_user_email_error" class="error text-sm"></span>
    </fieldset>
    <fieldset class="mt-5 flex flex-col gap-1">
        <label for="signup_user_password">
            {{__('Password','coursely')}}
            <span class="text-brand">*</span>
        </label>
        <div class="relative">
            <input class="w-full border border-gray text-brand-light-gray py-2.5 px-3 rounded-lg" type="password" placeholder="{{__('Enter password','coursely')}}" id="signup_user_password" name="signup_user_password">
            <button type="button" class="show-password-js absolute top-[14px] right-[14px]">
                <svg width="22" height="17" viewBox="0 0 22 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.0508 16L4.05078 1M8.85078 6.94157C8.47736 7.35326 8.25078 7.89403 8.25078 8.48631C8.25078 9.77609 9.3253 10.8217 10.6508 10.8217C11.2619 10.8217 11.8197 10.5994 12.2434 10.2334M19.0896 10.8217C19.9158 9.58482 20.2508 8.57613 20.2508 8.57613C20.2508 8.57613 18.0662 1.6 10.6508 1.6C10.2345 1.6 9.83465 1.62199 9.45078 1.66349M16.0508 13.8494C14.6734 14.7281 12.9001 15.3495 10.6508 15.3127C3.3277 15.193 1.05078 8.57613 1.05078 8.57613C1.05078 8.57613 2.10864 5.19808 5.25078 3.14332" stroke="#0F051A" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <span id="signup_user_password_error" class="error text-sm"></span>
        </div>

        <span class="text-sm text-brand-light-gray">{{__('Use 8 or more characters with a mix of letters, numbers & symbols','coursely')}}</span>
    </fieldset>

    <label class="flex gap-2 text-brand-dark mt-[32px]">
        <input type="checkbox" name="signup_user_agree" id="signup_user_agree" required>
        {{__('Agree to our','coursely')}} <a class="underline hover:text-brand" target="_blank" href="/terms-of-use">{{__('Terms of use','coursely')}}</a> and <a class="underline hover:text-brand" target="_blank" href="/privacy-policy">{{__('Privacy Policy','coursely')}}</a>
    </label>

    <button type="submit" class="text-white gap-2 w-full mt-[32px] py-[15px] brand-btn bg-brand-dark hover:bg-brand">
        {{__('Sign up','coursely')}}
        <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.16667 1L15 7M15 7L9.16667 13M15 7L1 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <span class="w-full mt-[32px]  block text-center">
                        {{__('Already have an account?','coursely')}}
                        <button type="button" class="underline hover:text-brand switch-to-login-js">{{__('Log in')}}</button>
                    </span>

</form>