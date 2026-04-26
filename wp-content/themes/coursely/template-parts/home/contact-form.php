<?php
/**
* Template part Home contact form
*/
?>
<div class="home-contact-form">
    <div class="col-md-12 hcf-left-part">
      <h2>Stay in touch with us!</h2>
      <p>Keep up-to-date with our newsletters on current events, lessons, performances and more.</p>
    </div>
    <div class="col-md-12 hcf-right-part">
        <form novalidate id="hc_form" class="hc-form" method="post">
            <input type="hidden" name="hc_nonce" value="<?php echo wp_create_nonce('home_contact_form'); ?>">
            <div class="fieldset">
                <label for="hc_name">Name</label>
                <input type="text" id="hc_name" name="hc_name"/>
                <span id="hc_name_error" class="input-error"></span>
            </div>
            <div class="fieldset">
                <label for="hc_email">Email</label>
                <input type="email" id="hc_email" name="hc_email"/>
                <span id="hc_email_error" class="input-error"></span>
            </div>
            <?php
            /*
            $public_key = get_field('public_key', 'option');
            $secret_key = get_field('secret_key', 'option');
            if($public_key && $secret_key){
                $recaptcha = new Recaptcha($public_key,$secret_key);
                echo $recaptcha->get_recaptcha_form_script();
                echo $recaptcha->get_recaptcha_form_block();
            }*/
            ?>
            <button class="brand-btn" type="submit">Sign me up</button>
        </form>
        <?php get_template_part('template-parts/global/popup/thanks'); ?>
    </div>
</div>  
