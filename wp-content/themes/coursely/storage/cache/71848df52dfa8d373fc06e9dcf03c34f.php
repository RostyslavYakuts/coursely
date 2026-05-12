
<div class="summary px-10 pt-5 pb-10 w-full rounded-[20px] bg-[#1C55E01A] ">
    <h2 class="mt-5 font-bold text-[32px]"><?php echo e(__('Summary','coursely')); ?></h2>
    <div class="mt-6 px-6 py-8 rounded-[20px] bg-white brand-shadow">
        <h3 class="p-0 m-0 font-bold text-[24px]"><?php echo e($data['plan']['duration']); ?></h3>
        <p class="mt-4 text-brand-text text-lg"><?php echo e(__('Stay consistent with your','coursely')); ?></p>

        <div class="mt-8">
            <span class="font-bold text-[36px]">$<?php echo e($data['plan']['price']); ?></span>
            <span class="text-brand-text">/ <?php echo e($data['plan']['duration']); ?></span>
        </div>
        <div class="my-8 w-full bg-gray h-[1px]"></div>

        <span class="font-bold lgx:text-lg">
                        <?php echo e($data['plans_features_text']); ?>

                    </span>

        <?php if($data['plan']['features']): ?>
            <div class="mt-6 flex flex-col gap-3">
                <?php $__currentLoopData = $data['plan']['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-row gap-3 items-center text-brand-text">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 0C7.21997 0 5.47991 0.527841 3.99987 1.51677C2.51983 2.50571 1.36628 3.91131 0.685088 5.55585C0.00389957 7.20038 -0.17433 9.00998 0.172937 10.7558C0.520203 12.5016 1.37737 14.1053 2.63604 15.364C3.89472 16.6226 5.49836 17.4798 7.24419 17.8271C8.99002 18.1743 10.7996 17.9961 12.4442 17.3149C14.0887 16.6337 15.4943 15.4802 16.4832 14.0001C17.4722 12.5201 18 10.78 18 9C18 6.61305 17.0518 4.32387 15.364 2.63604C13.6761 0.948212 11.387 0 9 0ZM13.23 6.46L8.79 12.62C8.65775 12.7985 8.46474 12.9225 8.24737 12.9686C8.03001 13.0146 7.8033 12.9796 7.61 12.87L5.06 11.38C4.85314 11.2553 4.70426 11.0536 4.64612 10.8192C4.58798 10.5848 4.62535 10.3369 4.75 10.13C4.87466 9.92313 5.07638 9.77425 5.3108 9.71612C5.54522 9.65798 5.79314 9.69535 6 9.82L7.81 10.9L11.81 5.41C11.9585 5.26128 12.1543 5.16919 12.3635 5.1497C12.5727 5.13021 12.7822 5.18454 12.9556 5.30329C13.1289 5.42204 13.2553 5.5977 13.3127 5.79984C13.3701 6.00198 13.355 6.21784 13.27 6.41L13.23 6.46Z" fill="#1C55E0"/>
                        </svg>
                        <span><?php echo e($feature['feature']); ?></span>
                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        <?php endif; ?>


    </div>
    <div class="w-full bg-white h-[1px] my-6"></div>
    <div class="py-5 flex justify-between items-center">
                <span class="font-bold text-[24px]">
                    <?php echo e(__('Total Due Today','coursely')); ?>

                </span>
        <span class="total-price font-bold text-[36px]">
                    $<?php echo e($data['plan']['price']); ?>

                </span>
    </div>
    <div class="w-full bg-white h-[1px] my-6"></div>
    <button type="submit" class="w-full flex items-center justify-center brand-btn-dark">
        <?php echo e(__('Pay now','coursely')); ?>

        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.1667 6L19 12M19 12L13.1667 18M19 12L5 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </button>
    <div class="agreement-info py-2.5 mt-6 font-medium flex flex-col gap-6">
        <span><?php echo e(__('Recurring billing every','coursely')); ?> <?php echo e($data['plan']['duration']); ?></span>
        <span>
                    By clicking “Pay Now”, you agree to our <a class="underline" href="<?php echo e(home_url('terms-of-service')); ?>">Terms of Service</a> and <a class="underline" href="<?php echo e(home_url('privacy-policy')); ?>">Privacy Policy</a>
                </span>
        <span>
                    <?php echo e(__('Payments are charged in USD. Payment provider fees may apply','coursely')); ?>

                </span>
    </div>
</div><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/checkout/summary.blade.php ENDPATH**/ ?>