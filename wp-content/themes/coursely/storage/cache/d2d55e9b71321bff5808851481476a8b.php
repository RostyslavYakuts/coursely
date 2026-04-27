
<?php if(is_user_logged_in()): ?>
    <?php return; ?>;
<?php endif; ?>
<div class="hidden auth-popup-js z-10 fixed w-full h-full bg-[#000005CC]">
    <div class="w-full h-full flex justify-center items-center">

        <div class="relative popup-content w-full max-w-[1096px] bg-white rounded-[40px] p-[40px]">
            <button type="button" class="close-popup-btn-js absolute top-[20px] right-[20px] ">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_120_17253)">
                        <path d="M25.3346 8.54667L23.4546 6.66667L16.0013 14.12L8.54797 6.66667L6.66797 8.54667L14.1213 16L6.66797 23.4533L8.54797 25.3333L16.0013 17.88L23.4546 25.3333L25.3346 23.4533L17.8813 16L25.3346 8.54667Z" fill="#666666"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_120_17253">
                            <rect width="32" height="32" fill="white"/>
                        </clipPath>
                    </defs>
                </svg></button>
            <div class="flex justify-between gap-[32px] ">
                <img src="<?php echo e($options['login_popup_image']['url']); ?>"
                     alt="<?php echo e($options['login_popup_image']['alt']); ?>"
                     width="492" height="600"
                     class="rounded-[20px] object-cover w-full max-w-[492px] h-auto"
                >

                <form id="login_form" class="auth-form-js  w-full max-w-[492px] hidden" method="post">
                    <span class="h3 font-bold text-[32px]"><?php echo e(__('Log In','coursely')); ?></span>
                    <fieldset class="mt-5 flex flex-col gap-1">
                        <label for="login_user_email" class="font-medium">
                            <?php echo e(__('Email address','coursely')); ?>

                            <span class="text-brand">*</span>
                        </label>
                        <input class="w-full border border-gray text-brand-light-gray py-2.5 px-3 rounded-lg" type="email" placeholder="<?php echo e(__('Enter email address','coursely')); ?>" id="login_user_email" name="login_user_email">
                        <span id="login_user_email_error" class="error text-sm"></span>
                    </fieldset>
                    <fieldset class="mt-5 flex flex-col gap-1">
                        <label for="login_user_password">
                            <?php echo e(__('Password','coursely')); ?>

                            <span class="text-brand">*</span>
                        </label>
                        <div class="relative">
                            <input class="w-full border border-gray text-brand-light-gray py-2.5 px-3 rounded-lg" type="password" placeholder="<?php echo e(__('Enter password','coursely')); ?>" id="login_user_password" name="login_user_password">
                            <button type="button" class="show-password-js absolute top-[14px] right-[14px]">
                                <svg width="22" height="17" viewBox="0 0 22 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.0508 16L4.05078 1M8.85078 6.94157C8.47736 7.35326 8.25078 7.89403 8.25078 8.48631C8.25078 9.77609 9.3253 10.8217 10.6508 10.8217C11.2619 10.8217 11.8197 10.5994 12.2434 10.2334M19.0896 10.8217C19.9158 9.58482 20.2508 8.57613 20.2508 8.57613C20.2508 8.57613 18.0662 1.6 10.6508 1.6C10.2345 1.6 9.83465 1.62199 9.45078 1.66349M16.0508 13.8494C14.6734 14.7281 12.9001 15.3495 10.6508 15.3127C3.3277 15.193 1.05078 8.57613 1.05078 8.57613C1.05078 8.57613 2.10864 5.19808 5.25078 3.14332" stroke="#0F051A" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                            <span id="login_user_password_error" class="error text-sm"></span>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="underline text-sm text-brand-light-gray hover:text-brand">
                                <?php echo e(__('Forget your password','coursely')); ?>

                            </button>
                        </div>


                    </fieldset>

                    <button type="submit" class="text-white gap-2 w-full py-[15px] mt-[32px] brand-btn bg-brand-dark hover:bg-brand">
                        <?php echo e(__('Log In','coursely')); ?>

                        <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.16667 1L15 7M15 7L9.16667 13M15 7L1 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <span class="mt-[32px] block text-center">
                        <?php echo e(__('Don`t have an account?','coursely')); ?>

                        <a href="/pricing" type="button" class="underline hover:text-brand"><?php echo e(__('Sign up')); ?></a>
                    </span>

                </form>
            </div>


        </div>

    </div>
</div><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/header/pop.blade.php ENDPATH**/ ?>