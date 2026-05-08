{{-- Account Tabs --}}
<div class="account-tabs-wrapper w-full lgx:w-[387px] lgx:min-w-[387px] flex flex-col gap-6 font-bold">
            <span class="text-[24px] pt-5 pb-6 border-b border-gray">
                {{__('Account Settings','coursely')}}
            </span>
    <div class="account-tabs account-tabs-js flex flex-col pb-6  border-b border-gray">
        <div data-tab="profile-settings" class="account-tab account-tab-js p-4 rounded-[10px] cursor-pointer active">
            {{__('Profile Settings','coursely')}}
        </div>
        <div data-tab="password" class="account-tab account-tab-js p-4 rounded-[10px] cursor-pointer">
            {{__('Password','coursely')}}
        </div>
        <div data-tab="subscription" class="account-tab account-tab-js p-4 rounded-[10px] cursor-pointer">
            {{__('Subscription & Payment','coursely')}}
        </div>
    </div>
    <a href="{!! $data['logout_url']  !!}" class="logout flex flex-row items-center gap-5 p-5">
        <svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.2624 17.8L16.9683 17.8C17.5299 17.8 18.0686 17.5787 18.4657 17.1849C18.8628 16.7911 19.0859 16.2569 19.0859 15.7L19.0859 3.09999C19.0859 2.54303 18.8628 2.00889 18.4657 1.61507C18.0686 1.22124 17.5299 0.999989 16.9683 0.999989L13.2624 0.999988M12.9992 9.39999L0.999219 9.39999M5.58437 4.59999L0.999219 9.39999L5.58437 14.2" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>{{__('Log Out','coursely')}}</span>
    </a>
</div>