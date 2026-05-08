
<div class="account-tabs-content-item password h-[626px]">
    <h2 class="leading-0 font-bold text-[20px] lgx:text-[32px] flex items-center gap-2">
        <button class="mobile-to-tabs-js lgx:hidden">
            <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.16667 1L1 5.375L5.16667 9.75M1 5.375H11" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <?php echo e(__('Password','coursely')); ?>

    </h2>
    <form id="profile_password_edit" class="mt-8 flex flex-col gap-5">
        <div class="fieldset flex flex-col gap-2 w-full">
            <label class="font-medium block" for="user_current_password">
                <?php echo e(__('Current password','coursely')); ?><sup class="text-brand">*</sup>
            </label>
            <input required class="rounded-[8px] border border-gray py-2.5 px-3" type="password" name="user_current_password" id="user_current_password" placeholder="<?php echo e(__('Enter current password','coursely')); ?>">
        </div>
        <div class="fieldset flex flex-col gap-2 w-full">
            <label class="font-medium block" for="user_new_password">
                <?php echo e(__('New password','coursely')); ?><sup class="text-brand">*</sup>
            </label>
            <input required class="rounded-[8px] border border-gray py-2.5 px-3" type="password" name="user_new_password" id="user_new_password" placeholder="<?php echo e(__('Enter new password','coursely')); ?>">
        </div>
        <div class="fieldset flex flex-col gap-2 w-full">
            <label class="font-medium block" for="user_repeat_new_password">
                <?php echo e(__('Repeat new password','coursely')); ?><sup class="text-brand">*</sup>
            </label>
            <input required class="rounded-[8px] border border-gray py-2.5 px-3" type="password" name="user_repeat_new_password" id="user_repeat_new_password" placeholder="<?php echo e(__('Repeat new password','coursely')); ?>">
        </div>

        <button type="submit" class="mt-8 brand-btn-dark w-full">
            <?php echo e(__('Save Changes','coursely')); ?>

        </button>
    </form>
</div><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/account/password.blade.php ENDPATH**/ ?>