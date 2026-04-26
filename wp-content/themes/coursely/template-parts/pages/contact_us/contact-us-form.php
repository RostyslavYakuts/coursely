<?php
/**
 * Template part Contact Us form
 */
?>
<form novalidate id="cu_form" class="cu-form" method="post">
    <input type="hidden" name="cu_nonce" value="<?php echo wp_create_nonce('contact_us_form'); ?>">
    <div class="fieldset">
        <label for="cu_name">Name <span class="grey">(REQUIRED)</span></label>
        <input type="text" id="cu_name" name="cu_name"/>
        <span id="cu_name_error" class="input-error"></span>
    </div>
    <div class="fieldset">
        <label for="cu_email">Email <span class="grey">(REQUIRED)</span></label>
        <input type="email" id="cu_email" name="cu_email"/>
        <span id="cu_email_error" class="input-error"></span>
    </div>
    <div class="inputs-hw">
        <div class="input-hw fieldset">
            <label for="cu_phone">Phone number <span class="grey">(REQUIRED)</span></label>
            <input type="tel" id="cu_phone" name="cu_phone"/>
            <span id="cu_phone_error" class="input-error"></span>
        </div>
        <div class="input-hw">
            <label for="cu_company">Company</label>
            <input type="text" id="cu_company" name="cu_company"/>
        </div>
    </div>

    <label for="cu_subject">Subject</label>
    <input type="text" id="cu_subject" name="cu_subject"/>
    <label for="cu_message">Your message</label>
    <textarea id="cu_message" name="cu_message"></textarea>
    <?php
    $public_key = get_field('public_key', 'option');
    $secret_key = get_field('secret_key', 'option');
    if($public_key && $secret_key){
        $recaptcha = new \ShibariWitch\Inc\Classes\Recaptcha($public_key,$secret_key);
        echo $recaptcha->get_recaptcha_form_script();
        echo $recaptcha->get_recaptcha_form_block();
    }
    ?>
    <button class="brand-btn" type="submit">Send</button>
</form>
<?php get_template_part('template-parts/global/popup/contact-us','thanks'); ?>
