<?php
/**
 * Template part for Footer
 *  Cookies Warning
 */
?>

<div id="warning_popup" class="container cookies-warning">
    <input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    <p> shibariwitch.com uses cookies to give you the best service. By continuing you are agree with our
        <a href="<?php echo get_site_url(); ?>/cookie-policy/" >Cookie Policy</a>.
    </p>
    <span id="warning_popup_close" class="brand-btn cookies-btn-js">Got it</span>
</div>
