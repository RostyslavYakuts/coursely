{{-- Processing Hero --}}
<div class="container">
    <div class="my-10 flex justify-center items-center"
         data-signup-token="{{ $data['token'] }}"
         data-nonce="{{ wp_create_nonce('check_checkout_status') }}"
    >

       <div class="processing-status flex flex-col justify-center items-center p-6 bg-white rounded-[40px] brand-shadow w-1/2 h-[300px]">
           <h1 class=" font-bold text-[24px]">
               {{__('Finalizing your subscription…','coursely')}}
           </h1>
           <div class="spinner"></div>
       </div>

    </div>
</div>

