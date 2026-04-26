<?php
/**
* Template part Who we are
*/
?>
<section id="wwa_block" class="who-we-are">
    <h2><span class="h2-decorated"></span>
        <?php
        $wwa_h2 = get_field('who_we_are_h2','option');
        $wwa_description = get_field('who_we_are_description','option');

        if($wwa_h2){
            echo $wwa_h2;
        }else{
            echo 'Who we are';
        }
        ?>
        <span class="h2-decorated-2"></span></h2>
    <p>
        <?php if($wwa_description){
        echo $wwa_description;
        }else{
        echo 'Shibari Look - it is creative shibari studio that provides stylistic performance, action, art representations, photos.';
        }
        ?>
        </p>

    <?php
    $pay_pall_link = 'https://www.paypal.me/annaleontieva?fbclid=IwAR0mF78cs0h1Iu5_KPQdkMFS5_YVU8DB_lRdxUldf8O8JufvF8D1MvZAAMY';
    if( get_field('paypal_donate_link','option') ){
        $pay_pall_link =  get_field('paypal_donate_link','option');
    }
    ?>
    <?php if ( get_display_donate_button() ): ?>
    <a class="brand-btn btn-support" href="<?php echo $pay_pall_link; ?>" rel="nofollow" target="_blank">Support Project</a>
    <?php endif; ?>
</section>