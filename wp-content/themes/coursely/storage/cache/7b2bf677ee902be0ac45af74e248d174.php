
<?php
    /**
     * @var array $data
     */
    $services = $data['services'];
    if(!$services) return;
?>
<section class="w-full container mx-auto py-[100px]">
    <div class="x-animation flex flex-col gap-3">
            <span data-animate="up" class="uppercase tracking-widest text-sm text-brand font-semibold">
                <?php echo __('Services','ws'); ?>

            </span>
        <h2 data-animate="up" class="text-4xl lg:text-5xl font-light text-brand leading-tight">
            <?php echo e($data['services_section_title']); ?>

        </h2>
        <p data-animate="down" class="text-gray-600 text-lg leading-relaxed">
            <?php echo e($data['services_section_description']); ?>

        </p>

    </div>
    <div class="max-w-7xl mx-auto px-6 text-center py-[100px] flex flex-row justify-between items-start gap-10 relative">
            <?php if($services->have_posts()): ?>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">

                    <?php while($services->have_posts()): ?>
                        <?php
                            $services->the_post();

                            $post_id   = get_the_ID();
                            $title     = get_the_title($post_id);
                            $link      = get_permalink($post_id);
                            $image     = get_the_post_thumbnail_url($post_id,'medium');
                            $date      = get_the_date('F d, Y', $post_id);
                            $excerpt   = get_the_excerpt($post_id);
                        ?>

                        <a href="<?php echo e($link); ?>"
                           class="p-10 bg-gray-50 rounded-3xl shadow-lg hover:shadow-2xl" data-animate="up">
                            <div class="overflow-hidden rounded-xl mb-4">
                                <img width="300" height="300"
                                     loading="lazy"
                                     decoding="async"
                                     src="<?php echo e($image); ?>"
                                     alt="<?php echo e($title); ?>"
                                     class="w-full h-[220px] object-cover
                                        transition duration-700
                                        group-hover:scale-105">
                            </div>
                            <h3 class="text-xl font-semibold mb-3"><?php echo e($title); ?></h3>
                            <p class="text-gray-500"><?php echo e($excerpt); ?></p>
                        </a>

                    <?php endwhile; ?>

                </div>

                <?php wp_reset_postdata(); ?>

            <?php endif; ?>

    </div>
</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/home/services.blade.php ENDPATH**/ ?>