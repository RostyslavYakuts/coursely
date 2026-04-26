<?php
/**
 * Template part adult content warning
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 26.01.2020
 * Time: 9:48
 */
?>
<div id="adult_warning_popup" class="container adult-warning">
    <input type="hidden" name="adult_ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    <div class="adult-warning-body">
        <?php
        $adult_warning_header = 'Adult warning header';
        $adult_warning_text = 'Please be advised that this is Sexually explicit material is not to be viewed by minors under the age of 18 or 21 in (some states of USA). If you are not of the legal age please leave this web site immediately.';
        if( get_field('adult_warning_header','option') ){
            $adult_warning_header = get_field('adult_warning_header','option');
        }
        if( get_field('adult_warning_text','option') ){
            $adult_warning_text = get_field('adult_warning_text','option');
        }
        ?>
        <h3><?php echo $adult_warning_header; ?></h3>
        <p><?php echo $adult_warning_text; ?></p>
        <?php
        $adult_warning_image = get_field('adult_warning_image','option');
        if( $adult_warning_image ){
            echo '<img src="'.$adult_warning_image['url'].'" alt="'.$adult_warning_image['alt'].'">';
        }else{
            echo '<p class="h1 flex-space-around-center white">18+</p>';
        }
        ?>

        <span id="adult_warning_popup_close" class="brand-btn adult-warning-btn adult-warning-btn-js">Yes, I'm over 18</span>.
    </div>

</div>