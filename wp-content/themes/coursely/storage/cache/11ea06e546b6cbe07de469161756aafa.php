
<?php
/**
* @var array $data
**/
$modal_id = $data['id']
?>

<div id="<?php echo e($modal_id); ?>" class="text-white bg-blur bg-half-black contact-us-modal hidden
 font-medium justify-center items-center gap-4 p-4 lgx:p-6 fixed
  top-[120px] right-[20px] z-30 w-[300px] rounded-[20px]">
    <div class="w-full h-full flex justify-center items-center gap-2">
        <span id="result_message" class="mt-2 flex flex-col gap-1 items-center justify-center"></span>
    </div>
    <button id="modal_close" class="close-contacts-modal absolute top-[10px] right-[10px]">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 1L1 15M15 15L1 1" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>
</div><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/form-modal.blade.php ENDPATH**/ ?>