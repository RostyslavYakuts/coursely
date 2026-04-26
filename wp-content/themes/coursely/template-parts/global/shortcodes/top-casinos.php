<?php
/**
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 12.10.2019
 * Time: 14:56
 */
$top_casinos_items = get_field('top_casinos_table','option');

if($top_casinos_items){
    echo '<table class="top-casinos-items"><tbody>';
    echo '<thead>
            <tr class="top-casinos-item th">
                <th>Casino</th>
                <th>Rating</th>
                <th>Welcome bonus</th>
                <th>Play</th>
            </tr>
        </thead>';
    foreach($top_casinos_items as $item){
        $referral_slug = get_field('referral_slug',$item->ID);
        $referral_url = get_field('referral_url',$item->ID);
        $site_url = get_site_url();
        echo '<tr class="top-casinos-item referral-btn" data-referral="'.$referral_url.'">';
        echo        '<td class="part left-part">';
                $casino_logo = get_field('logotype',$item->ID);
                    if($casino_logo){
                        echo '<div class="left-part-img-wrapper"><img src="'.$casino_logo['url'].'" alt="'.$casino_logo['alt'].'"></div>';
                    }
                echo '<span class="h3">'.$item->post_title.'</span>';
                $rating = get_field('rating',$item->ID);
                if($rating){
                echo '<div class="star-rating-default">
                            <div class="star-rating" style="width:'.intval($rating*20).'px"></div>
                      </div>';
                }
        echo' </td>';
        echo '<td class="part middle-part">';
        $bonuses = get_field('bonuses',$item->ID);
        if($bonuses){
            echo '<p>'.$bonuses.'</p>';
        }
        echo '</td>';
        echo '<td class="part right-part">';
        $review_url = get_field('review_page_url',$item->ID);


        if($referral_slug){
            echo '<a rel="nofollow" href="'.$site_url.'/rdr/'.$referral_slug.'" class="to-referral-btn-js button button-brand">Play now</a>';
        }
        if($review_url){
            echo '<a href="'.$review_url.'" class="review-link to-referral-btn-js">Review</a>';
        }
        echo '</td>';

        echo '</tr>';
    }
    echo '</tbody></table>';
}