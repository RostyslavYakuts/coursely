<?php
/**
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 12.10.2019
 * Time: 23:47
 */
$live_casino = get_field('live_casino','option');
if($live_casino){
    echo '<div class="live-casino">';
    echo '<img src="'.$live_casino['url'].'" alt="'.$live_casino['alt'].'">';
    echo '</div>';
}
