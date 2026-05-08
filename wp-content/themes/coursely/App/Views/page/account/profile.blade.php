{{-- Account Profile --}}
<div class="account-tabs-content-item active profile-settings h-[626px]">
    <h2 class="leading-0 font-bold text-[20px] lgx:text-[32px] flex items-center gap-2">
        <button class="mobile-to-tabs-js lgx:hidden">
            <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.16667 1L1 5.375L5.16667 9.75M1 5.375H11" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        {{__('Profile Settings','coursely')}}
    </h2>
    <form id="profile_settings_edit" class="mt-8 flex flex-col gap-5">
        <div class="fieldset user-image">
            <label class="cursor-pointer font-medium block relative w-[120px] max-w-[120px]" for="user_photo">

                <span class="block pb-1.5">{{__('Profile image')}}</span>
                <picture id="user_image_wrapper">
                    @if($data['user_photo'])
                        <img class="rounded-full object-cover w-[120px] h-[120px]"
                             src="{{$data['user_photo']['url']}}"
                             alt="user-{{$data['user_id']}}" width="120" height="120" loading="lazy" decoding="async">
                    @else
                        {!! $data['avatar'] !!}
                    @endif
                </picture>

                <input class="opacity-0 absolute top-0 left-0 z-0" type="file" id="user_photo" name="user_photo">
                <svg class="absolute bottom-0 right-0 z-10" width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 18C0 8.05888 8.05888 0 18 0C27.9411 0 36 8.05888 36 18C36 27.9411 27.9411 36 18 36C8.05888 36 0 27.9411 0 18Z" fill="#F4F4F5"/>
                    <path d="M18 26H27" stroke="#1C55E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22.5 9.50001C22.8978 9.10219 23.4374 8.87869 24 8.87869C24.2786 8.87869 24.5544 8.93356 24.8118 9.04017C25.0692 9.14677 25.303 9.30303 25.5 9.50001C25.697 9.697 25.8532 9.93085 25.9598 10.1882C26.0665 10.4456 26.1213 10.7214 26.1213 11C26.1213 11.2786 26.0665 11.5544 25.9598 11.8118C25.8532 12.0692 25.697 12.303 25.5 12.5L13 25L9 26L10 22L22.5 9.50001Z" stroke="#1C55E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </label>
        </div>
        <div class="fieldset flex flex-col gap-2 w-full">
            <label class="font-medium block" for="user_first_name">
                {{__('First Name','coursely')}}
            </label>
            <input class="rounded-[8px] border border-gray py-2.5 px-3" type="text" name="user_first_name" id="user_first_name" placeholder="{{$data['first_name']}}" value="{{$data['first_name']}}">
        </div>
        <div class="fieldset flex flex-col gap-2 w-full">
            <label class="font-medium block" for="user_last_name">
                {{__('Last Name','coursely')}}
            </label>
            <input class="rounded-[8px] border border-gray py-2.5 px-3" type="text" name="user_last_name" id="user_last_name" placeholder="{{$data['last_name']}}" value="{{$data['last_name']}}">
        </div>
        <div class="fieldset flex flex-col gap-2 w-full">
            <label class="font-medium block" for="user_email">
                {{__('Current Email Address','coursely')}}
            </label>
            <input class="rounded-[8px] border border-gray py-2.5 px-3" type="text" name="user_email" id="user_email" placeholder="{{$data['email']}}" value="{{$data['email']}}">
        </div>
        <button type="submit" class="mt-8 brand-btn-dark w-full">
            {{__('Save Changes','coursely')}}
        </button>
    </form>
</div>