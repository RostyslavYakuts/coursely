
<?php
    /**
    * @var $data
    */

    $text = $data['text'] ?? '';
    if(!$text){
         $button_text = $data['button_title'] ?? '';
         $button_text = $button_text ?: '';
    }else{
        $button_text = $text;
    }
    $aria_label = $data['aria_label'] ?? '';
    $aria_label_attr = '';
    if($aria_label){
        $aria_label_attr = 'aria-label="'.$aria_label.'"';
    }
    $extra_classes = $data['tw_classes'] ?? '';
    $class = 'class="uppercase flex justify-center items-center no-underline text-center font-bold
    cursor-pointer rounded bg-brand-accent hover:bg-white border border-brand-accent p-2 transition-colors duration-300 ease-in-out ' . $extra_classes . '"';
    $data_animate = $data['data_animate'] ?? '';
    $data_animate_attr = '';
    $tag = $data['button_tag'] ?? 'a';
    $type = $data['type'] ?? 'button';
    $href = $data['button_link'] ?? '';
    $target = $data['target'] ?? '';
    $target_attr = '';
    $rel = $data['rel'] ?? '';
    $rel_attr = '';
    if($rel){
        $rel_attr = 'rel="'.$rel.'"';
    }
    $href_attr = 'href="'.$href.'"';
    if($target){
        $target_attr = 'target="'.$target.'"';
    }

    $type_attr = '';
    if($tag !== 'a'){
        $href_attr = '';
        $target_attr = '';
        $nofollow = '';
        $type_attr = 'type="'.$type.'"';
    }
    if($data_animate){
        $data_animate_attr = 'data-animate="'.$data_animate.'"';
    }
?>

<<?php echo e($tag); ?> <?php echo $aria_label_attr; ?> <?php echo $data_animate_attr; ?> <?php echo $type_attr; ?> <?php echo $href_attr; ?> <?php echo $target_attr; ?> <?php echo $rel_attr; ?> <?php echo $class; ?>>
    <?php echo $button_text; ?>

</<?php echo e($tag); ?>><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/brand-btn.blade.php ENDPATH**/ ?>