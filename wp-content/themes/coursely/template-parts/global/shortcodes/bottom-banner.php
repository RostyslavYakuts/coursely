<?php
/**
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 13.10.2019
 * Time: 2:06
 */
$bottom_banner = get_field('bottom_banner','option');
$bottom_banner_link = get_field('bottom_banner_link','option');
if($bottom_banner && $bottom_banner_link){
    echo '<div class="bottom-banner referral-btn" data-referral="'.$bottom_banner_link.'">
                <img src="'.$bottom_banner['url'].'" alt="'.$bottom_banner['alt'].'" >
          </div>  ';

}