
<section class="mx-auto container flex flex-col md:flex-row gap-8 mt-10">

    <div class="w-full md:w-[67%] flex flex-col prose-base">
        <h1 class="text-5xl font-light text-gray-900 tracking-wide mb-6">
            <?php echo e($data['title']); ?>

        </h1>
        <span class="flex items-center gap-2">
                <span class=""><?php echo __('Author','coursely'); ?>:</span>
                <img width="100" height="100" loading="lazy" decoding="async"
                     class="rounded-full shadow"
                     src="<?php echo e($data['author_photo_url']); ?>" alt=" <?php echo e($data['author_name']); ?>">
                <a class="underline font-bold" href="<?php echo e($data['author_url']); ?>">
                    <?php echo e($data['author_name']); ?>

                </a>
        </span>
        <div class="w-full flex flex-wrap items-center gap-6 leading-none text-sm">
            <span class="flex items-center gap-1">
                <i class="text-brand fa fa-calendar-plus-o" aria-hidden="true"></i>
                <span class=""><?php echo __('Published','coursely'); ?>:</span>
                <time datetime="<?php echo e($data['datetime']); ?>" class="font-bold">
                    <?php echo e($data['date']); ?>

                </time>
            </span>
            <span class="flex items-center gap-1">
                <i class="text-brand fa fa-calendar-check-o" aria-hidden="true"></i>
                <span class=""><?php echo __('Updated','coursely'); ?>:</span>
                <time datetime="<?php echo e($data['modified_datetime']); ?>" class="font-bold">
                    <?php echo e($data['modified_date']); ?>

                </time>
            </span>

        </div>
        <?php if($data['toc']): ?>
        <div class="js-toc_table_list_heading mt-2" aria-label="Table of Contents">
            <h2><?php echo __('Table of content','coursely'); ?>:</h2>
            <?php echo $data['toc']; ?>

        </div>
        <?php endif; ?>
        <div class="py-[50px]">
            <?php echo $data['content']; ?>

        </div>

    </div>

    <div class="w-full pb-10 md:w-[32%] flex flex-col gap-6">
        <?php echo $data['thumbnail']; ?>

        <?php echo $__env->make('global.social-share',['social'=>$data['social']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('single.post.category-block',['categories'=>$data['categories']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('single.post.tag-block',['tags'=>$data['tags']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/single/post/content.blade.php ENDPATH**/ ?>