<?php
/**
 * Template part for Hero Order Form
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 27.12.2019
 * Time: 0:08
 */
?>
<div class="hero-cta-form-wrapper">
    <form novalidate id="hero_cta_form" method="post">
        <input type="hidden" name="hero_nonce" value="<?php echo wp_create_nonce('hero_order_form'); ?>">
        <div class="fieldset">
            <label for="hero_cta_name">Your Name (required)</label>
            <input id="hero_cta_name" type="text" name="hero_cta_name">
            <span id="hero_cta_name_error" class="input-error"></span>
        </div>
        <div class="fieldset">
            <label for="hero_cta_email">Your Email (required)</label>
            <input id="hero_cta_email" type="email" name="hero_cta_email">
            <span id="hero_cta_email_error" class="input-error"></span>
        </div>
        <label for="hero_cta_service">Select service</label>
        <select id="hero_cta_service" name="hero_cta_service">
            <?php
            $args = array( 'post_type'=>'proposition','posts_per_page' => -1,'post_status'=> 'publish' );
            $services = get_posts($args);
            foreach( $services as $service ){
                echo '<option value="'.get_the_title($service->ID).'">'.get_the_title($service->ID).'</option>';
            }
            ?>
        </select>
        <label for="hero_cta_msg">Your message</label>
        <textarea id="hero_cta_msg" name="hero_cta_msg"></textarea>
        <?php /* <div class="fieldset flex-center">
            <?php
            $public_key = get_field('public_key', 'option');
            $secret_key = get_field('secret_key', 'option');
            if($public_key && $secret_key){
                $recaptcha = new Recaptcha($public_key,$secret_key);
                echo $recaptcha->get_recaptcha_form_script();
                echo $recaptcha->get_recaptcha_form_block();
            }
            ?>
        </div> */ ?>
        <button class="brand-btn" type="submit">Send</button>
        <span class="hero-cta-form-close hero-form-close-js"><i class="fa fa-times" aria-hidden="true"></i></span>
        <div class="hero-thanks-popup">
            <span class="h2">Thank you!</span>
            <p>Your message is successfully sent</p>
        </div>
    </form>
</div>