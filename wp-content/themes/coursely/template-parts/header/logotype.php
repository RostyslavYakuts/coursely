<?php
/**
* Logotype template part
* @location header.php
*/
$logo_home_page = get_field('logo_image','option');
if($logo_home_page){
    echo '<div class="logo-block">';
    if( is_front_page() ){
        echo '<img width="197" height="169" src="'.$logo_home_page['url'].'" alt="'.$logo_home_page['alt'].'">';
    }else{
        echo '<a class="logo logo_laptop" href="'.get_option("home").'">';
        echo '<img width="197" height="169" src="'.$logo_home_page['url'].'" alt="'.$logo_home_page['alt'].'"></a>';
    }
    echo '</div>';
}

