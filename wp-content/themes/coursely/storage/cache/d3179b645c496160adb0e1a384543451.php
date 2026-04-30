

<?php if($data['plans']): ?>
    <?php
        $feature_svg = '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9 0C7.21997 0 5.47991 0.527841 3.99987 1.51677C2.51983 2.50571 1.36628 3.91131 0.685088 5.55585C0.00389957 7.20038 -0.17433 9.00998 0.172937 10.7558C0.520203 12.5016 1.37737 14.1053 2.63604 15.364C3.89472 16.6226 5.49836 17.4798 7.24419 17.8271C8.99002 18.1743 10.7996 17.9961 12.4442 17.3149C14.0887 16.6337 15.4943 15.4802 16.4832 14.0001C17.4722 12.5201 18 10.78 18 9C18 6.61305 17.0518 4.32387 15.364 2.63604C13.6761 0.948212 11.387 0 9 0ZM13.23 6.46L8.79 12.62C8.65775 12.7985 8.46474 12.9225 8.24737 12.9686C8.03001 13.0146 7.8033 12.9796 7.61 12.87L5.06 11.38C4.85314 11.2553 4.70426 11.0536 4.64612 10.8192C4.58798 10.5848 4.62535 10.3369 4.75 10.13C4.87466 9.92313 5.07638 9.77425 5.3108 9.71612C5.54522 9.65798 5.79314 9.69535 6 9.82L7.81 10.9L11.81 5.41C11.9585 5.26128 12.1543 5.16919 12.3635 5.1497C12.5727 5.13021 12.7822 5.18454 12.9556 5.30329C13.1289 5.42204 13.2553 5.5977 13.3127 5.79984C13.3701 6.00198 13.355 6.21784 13.27 6.41L13.23 6.46Z" fill="#1C55E0"/>
</svg>';
        $feature_svg_popular = '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9 0C7.21997 0 5.47991 0.527841 3.99987 1.51677C2.51983 2.50571 1.36628 3.91131 0.685088 5.55585C0.00389957 7.20038 -0.17433 9.00998 0.172937 10.7558C0.520203 12.5016 1.37737 14.1053 2.63604 15.364C3.89472 16.6226 5.49836 17.4798 7.24419 17.8271C8.99002 18.1743 10.7996 17.9961 12.4442 17.3149C14.0887 16.6337 15.4943 15.4802 16.4832 14.0001C17.4722 12.5201 18 10.78 18 9C18 6.61305 17.0518 4.32387 15.364 2.63604C13.6761 0.948212 11.387 0 9 0ZM13.23 6.46L8.79 12.62C8.65775 12.7985 8.46474 12.9225 8.24737 12.9686C8.03001 13.0146 7.8033 12.9796 7.61 12.87L5.06 11.38C4.85314 11.2553 4.70426 11.0536 4.64612 10.8192C4.58798 10.5848 4.62535 10.3369 4.75 10.13C4.87466 9.92313 5.07638 9.77425 5.3108 9.71612C5.54522 9.65798 5.79314 9.69535 6 9.82L7.81 10.9L11.81 5.41C11.9585 5.26128 12.1543 5.16919 12.3635 5.1497C12.5727 5.13021 12.7822 5.18454 12.9556 5.30329C13.1289 5.42204 13.2553 5.5977 13.3127 5.79984C13.3701 6.00198 13.355 6.21784 13.27 6.41L13.23 6.46Z" fill="white"/>
</svg>
';
    ?>
    <div class="container mx-auto">
        <div class="plans-wrapper mt-16 grid grid-cols-1 md:grid-cols-2 lgx:grid-cols-4 gap-5">
            <?php $__currentLoopData = $data['plans']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="plan <?php echo e($plan['is_popular'] ? 'bg-brand-dark lgx:-mt-5 lgx:mb-5' :'bg-white'); ?> rounded-[20px] py-8 px-6 w-full flex flex-col gap-5 <?php echo e($plan['is_popular'] ?? 'popular'); ?>" data-type="<?php echo e($plan['type']); ?>">

                    <span class="font-bold text-[20px] lgx:text-[24px] <?php echo e($plan['is_popular'] ? 'text-white' :'text-brand-dark'); ?>">
                        <?php echo e($plan['duration']); ?>

                    </span>

                    <span class="<?php echo e($plan['is_popular'] ? 'text-white' :'text-brand-text'); ?> lgx:text-lg">
                        <?php echo e($plan['description']); ?>

                    </span>

                    <span class="highlighted-text font-bold <?php echo e($plan['is_popular'] ? 'text-white' :'text-brand'); ?>">
                        <?php echo e($plan['highlighted_text']); ?>

                    </span>

                    <span class="flex flex-row items-end gap-1">
                        <span class="<?php echo e($plan['is_popular'] ? 'text-white' :'text-brand-dark'); ?> font-bold text-[32px] lgx:text-[36px] leading-none">
                            <?php echo e($plan['price']); ?>

                        </span>
                        <span class="<?php echo e($plan['is_popular'] ? 'text-white' :'text-brand-text'); ?> ">/<?php echo e($plan['per_period']); ?></span>
                    </span>

                    <button data-plan-type="<?php echo e($plan['type']); ?>" class="bg-white flex justify-center items-center gap-2 p-3 w-full rounded-full border border-brand-gray text-lg hover:text-white hover:bg-brand-dark">
                        <?php echo e($data['plans_cta']); ?>

                        <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.16667 1L15 7M15 7L9.16667 13M15 7L1 7" stroke="#111230" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div class="w-full h-[1px] bg-brand-gray"></div>

                    <span class="font-bold lgx:text-lg <?php echo e($plan['is_popular'] ? 'text-white' :'text-brand-dark'); ?>">
                        <?php echo e($data['plans_features_text']); ?>

                    </span>

                    <?php if($plan['features']): ?>
                        <?php $__currentLoopData = $plan['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex flex-row gap-3 items-center <?php echo e($plan['is_popular'] ? 'text-white' :'text-brand-text'); ?>">
                                <?php if($plan['is_popular']): ?>
                                    <?php echo $feature_svg_popular; ?>

                                <?php else: ?>
                                    <?php echo $feature_svg; ?>

                                <?php endif; ?>
                                <span><?php echo e($feature['feature']); ?></span>
                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/pricing.blade.php ENDPATH**/ ?>