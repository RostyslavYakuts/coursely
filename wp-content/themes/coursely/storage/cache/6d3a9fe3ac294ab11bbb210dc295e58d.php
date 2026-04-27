

<div class="bg-brand-dark w-full min-h-[520px] py-8 flex items-center justify-center">
    <section id="banner" class="container mx-auto flex flex-col l:flex-row items-center justify-center gap-10">

        

        <img data-animate="up" src="<?php echo e($data['banner_image']['url']); ?>"
             width="500"
             height="350"
             alt="<?php echo e($data['banner_image']['alt']); ?>"
             loading="lazy" decoding="async"
             class="w-full h-auto max-w-[300px] l:max-w-[500px] object-cover">


        
        <div class="w-full text-white mx-auto flex flex-col items-center text-center gap-6">

            <h2 data-animate="up"  class="text-4xl md:text-5xl lg:text-6xl font-light  leading-tight">
                <?php echo $data['banner_title']; ?>

            </h2>

            <p data-animate="down"  class="ext-lg text-white/80 max-w-xl">
                <?php echo e($data['banner_description']); ?>

            </p>

            

            <?php echo $__env->make('global.brand-btn',[
                 'data'=>[
                     'data_animate'=>'down',
                     'target'=>'',
                     'rel'=>'noopener noreferrer',
                     'tw_classes'=>'text-white hover:text-brand-accent w-[300px]',
                     'button_link'=>$data['banner_cta_link'] ?? '',
                     'button_title'=>__('WooCommerce Product Filter','ws'),
                 ]
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>

    </section>
</div>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/home/banner.blade.php ENDPATH**/ ?>