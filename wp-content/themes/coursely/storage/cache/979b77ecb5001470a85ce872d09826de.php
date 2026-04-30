

<?php
    /**
     * @var bool $wrapper
     */

    $class_css = '';
    if($wrapper){
        $class_css = 'mt-[100px] container mx-auto';
    }

    if(function_exists('yoast_breadcrumb') && !is_front_page() && !is_404()) {
        yoast_breadcrumb( '<div class="'.$class_css.' breadcrumbs-wrapper py-5">
        <div id="breadcrumbs" class="mt-10 [&_a]:text-brand breadcrumbs text-base overflow-y-auto whitespaces-nowrap flex items-center gap-x-2 breadcrumbs ">','</div></div>' );
    }
?>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/breadcrumbs.blade.php ENDPATH**/ ?>