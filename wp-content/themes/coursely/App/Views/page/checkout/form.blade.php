{{-- Checkout Form --}}
@php
$password_icon = '<svg width="22" height="17" viewBox="0 0 22 17" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M19.0508 16L4.05078 1M8.85078 6.94157C8.47736 7.35326 8.25078 7.89403 8.25078 8.48631C8.25078 9.77609 9.3253 10.8217 10.6508 10.8217C11.2619 10.8217 11.8197 10.5994 12.2434 10.2334M19.0896 10.8217C19.9158 9.58482 20.2508 8.57613 20.2508 8.57613C20.2508 8.57613 18.0662 1.6 10.6508 1.6C10.2345 1.6 9.83465 1.62199 9.45078 1.66349M16.0508 13.8494C14.6734 14.7281 12.9001 15.3495 10.6508 15.3127C3.3277 15.193 1.05078 8.57613 1.05078 8.57613C1.05078 8.57613 2.10864 5.19808 5.25078 3.14332" stroke="#0F051A" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
</svg>';
@endphp
<section class="container">
    <form id="checkout_form" method="post" class="brand-shadow mb-10 p-10 flex flex-col lgx:flex-row justify-between items-start gap-10 bg-white rounded-[40px] mt-[124px]">

        <div class="sign-up w-full py-5">
            <h1 class="mt-5 font-bold text-[32px]">{{__('Sign Up','coursely')}}</h1>
            <div class="mt-10">
                <h2 class="font-bold text-[24px]">{{__('Personal Information','coursely')}}</h2>

                <div class="input-block mt-5 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_name">{{__('First Name','coursely')}}<sup class="text-brand">*</sup></label>
                    <input class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" required placeholder="{{__('Enter first name','coursely')}}" type="text" id="subscriber_name" name="subscriber_name">
                    <span id="subscriber_name_err" class="input-error"></span>
                </div>
                <div class="input-block mt-4 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_email">{{__('Email Address','coursely')}}<sup class="text-brand">*</sup></label>
                    <input class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" required placeholder="{{__('Enter email address','coursely')}}" type="email" id="subscriber_email" name="subscriber_email">
                    <span id="subscriber_email_err" class="input-error"></span>
                </div>
                <div class="input-block mt-4 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_phone">{{__('Phone Number','coursely')}}<sup class="text-brand">*</sup></label>
                    <input class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" required placeholder="{{__('Enter phone number','coursely')}}" type="tel" id="subscriber_phone" name="subscriber_phone">
                    <span id="subscriber_phone_err" class="input-error"></span>
                </div>

                <h2 class="mt-10 font-bold text-[24px]">{{__('Account Security','coursely')}}</h2>

                <div class="input-block mt-5 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_password">{{__('Password','coursely')}}<sup class="text-brand">*</sup></label>
                    <input minlength="8" maxlength="64" class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" required placeholder="{{__('Enter password','coursely')}}" type="password" id="subscriber_password" name="subscriber_password">
                    <span class="text-brand-text text-sm">
                        {{__('Use 8 or more characters with a mix of letters, numbers & symbols','coursely')}}
                    </span>
                    <button data-input="subscriber_password" aria-label="Show password" type="button" class="togglePassword absolute top-[41px] right-3">
                        {!! $password_icon !!}
                    </button>
                    <span id="subscriber_password_err" class="input-error"></span>
                </div>
                <div class="input-block mt-4 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_password_confirm">{{__('Confirm password','coursely')}}<sup class="text-brand">*</sup></label>
                    <input minlength="8" maxlength="64" class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" required placeholder="{{__('Enter password','coursely')}}" type="password" id="subscriber_password_confirm" name="subscriber_password_confirm">
                    <button data-input="subscriber_password_confirm" aria-label="Show password" type="button" class="togglePassword absolute top-[41px] right-3">
                        {!! $password_icon !!}
                    </button>
                    <span id="subscriber_password_confirm_err" class="input-error"></span>
                </div>

                <h2 class="mt-10 font-bold text-[24px]">{{__('Billing Address','coursely')}}</h2>
                <div class="input-block mt-5 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_company_name">{{__('Company Name (Optional)','coursely')}}</label>
                    <input class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" placeholder="{{__('Enter company name','coursely')}}" type="text" id="subscriber_company_name" name="subscriber_company_name">
                    <span id="subscriber_company_name_err" class="input-error"></span>
                </div>
                <div class="input-block mt-5 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_street_address">{{__('Street Address','coursely')}}<sup class="text-brand">*</sup></label>
                    <input required class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" placeholder="{{__('Enter street address','coursely')}}" type="text" id="subscriber_street_address" name="subscriber_street_address">
                    <span id="subscriber_street_address_err" class="input-error"></span>
                </div>
                <div class="input-block mt-5 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_street_address_2">{{__('Street Address 2 (Optional)','coursely')}}</label>
                    <input class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" placeholder="{{__('Enter street address 2','coursely')}}" type="text" id="subscriber_street_address_2" name="subscriber_street_address_2">
                    <span id="subscriber_street_address_2_err" class="input-error"></span>
                </div>
                <div class="input-block mt-5 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_city">{{__('City','coursely')}}<sup class="text-brand">*</sup></label>
                    <input required class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" placeholder="{{__('Enter city','coursely')}}" type="text" id="subscriber_city" name="subscriber_city">
                    <span id="subscriber_city_err" class="input-error"></span>
                </div>
                <div class="input-block mt-5 relative flex flex-col gap-1">
                    <label class="font-medium"  for="subscriber_country">{{__('Country','coursely')}}<sup class="text-brand">*</sup></label>
                    <select required class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" type="text" id="subscriber_country" name="subscriber_country">
                        <option value=""></option>
                        @foreach($data['countries'] as $code => $name)
                            <option value="{{ $code }}">{{ $name }}</option>
                        @endforeach
                    </select>

                    <span id="subscriber_country_err" class="input-error"></span>
                </div>
                <div class="mt-5 flex justify-between items-center gap-5">
                    <div class="input-block relative flex flex-col gap-1">
                        <label class="font-medium"  for="subscriber_state">{{__('State','coursely')}}<sup class="text-brand">*</sup></label>
                        <input required class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" placeholder="{{__('Enter state','coursely')}}" type="text" id="subscriber_state" name="subscriber_state">
                        <span id="subscriber_state_err" class="input-error"></span>
                    </div>
                    <div class="input-block relative flex flex-col gap-1">
                        <label class="font-medium"  for="subscriber_zip">{{__('Postcode','coursely')}}<sup class="text-brand">*</sup></label>
                        <input required class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" placeholder="{{__('Enter postcode','coursely')}}" type="text" id="subscriber_zip" name="subscriber_zip">
                        <span id="subscriber_zip_err" class="input-error"></span>
                    </div>

                </div>

                <h2 class="mt-10 font-bold text-[24px]">{{__('Payment Details','coursely')}}</h2>

                <div id="checkout_payment" class="mt-5">
                    <div class="input-block relative flex flex-col gap-1">
                        <label class="font-medium"  for="subscriber_cardholder_name">{{__('Cardholder Name (Optional)','coursely')}}</label>
                        <input class="bg-transparent rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray" placeholder="{{__('Enter cardholder name','coursely')}}" type="text" id="subscriber_cardholder_name" name="subscriber_cardholder_name">
                        <span id="subscriber_cardholder_name_err" class="input-error"></span>
                    </div>

                    <div class="input-block relative flex flex-col gap-1 mt-5">
                        <span class="font-medium">{{__('Card number','coursely')}}<sup class="text-brand">*</sup></span>
                        <div id="card_number" class=" rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray"></div>
                        <span id="card_number_err" class="input-error"></span>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-4">
                        <div class="input-block relative flex flex-col gap-1">
                            <span class="font-medium">{{__('Expiration Date','coursely')}}<sup class="text-brand">*</sup></span>
                            <div id="card_expiry" class="rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray"></div>
                            <span id="card_expiry_err" class="input-error"></span>
                        </div>
                        <div class="input-block relative flex flex-col gap-1">
                            <span class="font-medium">{{__('CVV','coursely')}}<sup class="text-brand">*</sup></span>
                            <div id="card_cvc" class="rounded-lg active:border-brand h-[44px] py-[10px] px-[12px] border border-gray"></div>
                            <span id="card_cvc_err" class="input-error"></span>
                        </div>
                    </div>

                </div>


            </div>




        </div>

        @include('page.checkout.summary')

    </form>
</section>