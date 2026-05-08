{{-- Account Hero --}}

<section class="container">
    <div class="mt-[124px]">
        <h1 class="font-bold text-[48px]">
            {{__('My Account','coursely')}}
        </h1>
    </div>

    <div class="relative account-settings mt-10 bg-white rounded-[40px] brand-shadow p-6 flex flex-col lgx:flex-row gap-10 items-start">
       @include('page.account.tabs')
        <div class="account-tabs-content w-full hidden lgx:block bg-white p-5 border border-gray rounded-[20px]">
            @include('page.account.profile')
            @include('page.account.password')
            @include('page.account.subscription')
        </div>
    </div>

</section>