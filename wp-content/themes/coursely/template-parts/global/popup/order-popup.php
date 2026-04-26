<?php
/**
 * Template part Order Popup
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 28.01.2020
 * Time: 10:31
 */
?>
<div class="footer-order-popup">
    <form id="order_form" class="order-form" novalidate method="post">
        <span class="footer-order-form-close footer-order-form-close-js"><i class="fa fa-times" aria-hidden="true"></i></span>
        <h3>Quick order</h3>
        <input type="hidden" id="order_nonce" name="order_nonce" value="<?php echo wp_create_nonce('footer_order_form'); ?>">
        <input type="hidden" id="ff_order" name="ff_order">
        <fieldset>
            <label for="ff_email">Your Email</label>
            <input type="email" id="ff_email" name="ff_email">
            <span id="ff_email_error" class="input-error"></span>
        </fieldset>

        <button class="brand-btn" type="submit">Submit</button>
    </form>
    <?php get_template_part('template-parts/global/popup/thanks'); ?>
</div>
