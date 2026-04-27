
<?php
    use coursely\App\Core\Helpers\SeoHelper;
    use coursely\App\Core\OptionsData
?>
        <!DOCTYPE html>
<html <?php language_attributes(); ?> class="h-full">
<head>
    <meta charset="utf-8">
    <title><?php echo e(SeoHelper::seo_title()); ?></title>
    <?php echo $__env->make('global.header.favicons', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="True">
    <meta name="viewport" content="initial-scale=1.0, width=device-width user-scalable=yes  viewport-fit=cover">
    <meta name="google-site-verification" content="e43k2m_4IYRCD6iZlY0jFb0NoqiVWEsBpo6fD8S3F8s" />
    <?php wp_head(); ?>
</head>
<body <?php body_class('h-full bg-white text-slate-800') ?> >

<main class="total-wrapper min-h-full">

    <?php echo $__env->make('global.header.total-header', ['options' => OptionsData::get_header_data() ?? []], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>
</main>
<?php echo $__env->make('global.footer.footer',['options' => OptionsData::get_footer_data() ?? []], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/layout.blade.php ENDPATH**/ ?>