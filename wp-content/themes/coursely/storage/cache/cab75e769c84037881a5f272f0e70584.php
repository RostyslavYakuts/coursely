
<section id="my-process" class="w-full bg-gray-50 py-[120px]">
    <div class="container mx-auto px-6">

        
        <div class="text-center mb-16">
            <h2 data-animate="up" class="text-4xl lg:text-5xl font-light text-brand leading-tight">
               <?php echo e($data['process_section_title']); ?>

            </h2>
            <p data-animate="down" class="mt-4 text-gray-600 text-lg max-w-2xl mx-auto">
                <?php echo e($data['process_section_description']); ?>

            </p>
        </div>

        
        <?php if($data['process']): ?>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12" data-workflow>
                <?php $__currentLoopData = $data['process']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-step
                         class="opacity-0 scale-75 translate-y-10 transition-all duration-700 flex flex-col items-center text-center bg-white rounded-3xl p-8 shadow-lg">

                        <div class="w-16 h-16 flex items-center justify-center rounded-full bg-brand text-white font-bold text-xl mb-6">
                            <?php echo e($key+1); ?>

                        </div>

                        <h3 class="text-brand-dark text-xl font-semibold mb-2">
                            <?php echo e($item['title']); ?>

                        </h3>

                        <p class="text-gray-500 leading-relaxed">
                            <?php echo e($item['description']); ?>

                        </p>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

    </div>
</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/home/process.blade.php ENDPATH**/ ?>