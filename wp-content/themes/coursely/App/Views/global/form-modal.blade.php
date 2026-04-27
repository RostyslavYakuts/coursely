{{-- Form Modal --}}
@php
/**
* @var array $data
**/
$modal_id = $data['id']
@endphp

<div id="{{$modal_id}}" class="text-white bg-blur bg-half-black contact-us-modal hidden
 font-medium justify-center rounded items-center gap-4 p-4 lgx:p-6 fixed
  top-[100px] left-[20px] z-20 w-calc-100-40 h-calc-100-100">
    <div class="w-full h-full flex justify-center items-center gap-2">
        <span id="result_message" class="flex flex-col gap-3 items-center justify-center"></span>
    </div>
    <button id="modal_close" class="close-contacts-modal absolute top-[19px] right-[19px]">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 1L1 15M15 15L1 1" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>
</div>