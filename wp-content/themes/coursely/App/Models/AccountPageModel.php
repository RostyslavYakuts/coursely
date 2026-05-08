<?php

namespace coursely\App\Models;

class AccountPageModel implements ModelInterface
{
    public \WP_Post $post;
    public function __construct($post){
        $this->post = $post;
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function get_post_data(): array
    {
        $id = $this->post->ID;
        $content = apply_filters('the_content', get_the_content());

        $user_id = get_current_user_id();
        $user = get_userdata($user_id);
        $first_name = $user->first_name;
        $last_name  = $user->last_name;
        $email      = $user->user_email;
        $user_photo = get_field('user_photo','user_'.$user_id) ?? [];
        $avatar = get_avatar($user_id,120);
        $active_subscription = $this->get_active_subscription($user_id);
        $stripe_price_id = $active_subscription['stripe_price_id'] ?? '';
        $active_subscription_price = $this->get_subscription_price_by_stripe_price_id($stripe_price_id);
        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'thumbnail' => get_the_post_thumbnail(),
            'content' => $content,
            'user_id' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'user_photo' => $user_photo,
            'avatar' => $avatar,
            'logout_url'=>wp_logout_url(home_url()),
            'invoices' => $this->get_user_invoices($user_id) ?? [],
            'active_subscription'=>$active_subscription,
            'active_subscription_price'=>$active_subscription_price,
            'activate_subscription_link'=>get_field('activate_subscription_link','options'),
            'next_payment' => !empty($active_subscription['current_period_end'])
                ? new \DateTime($active_subscription['current_period_end'])->format('m/d/y')
                : '',
        ];
    }

    public function get_user_invoices(int $userId): array
    {
        global $wpdb;

        $table = $wpdb->prefix . 'coursely_invoices';

        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT 
                id,
                stripe_invoice_id,
                status,
                total,
                currency,
                plan_name,
                plan_interval,
                paid_at,
                created_at
             FROM {$table}
             WHERE user_id = %d
             ORDER BY created_at DESC",
                $userId
            ),
            ARRAY_A
        );
    }

    public function get_active_subscription(int $userId): ?array
    {
        global $wpdb;

        $table = $wpdb->prefix . 'coursely_subscriptions';

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$table}
             WHERE user_id = %d AND status = 'active'
             LIMIT 1",
                $userId
            ),
            ARRAY_A
        );
    }

    public function get_subscription_price_by_stripe_price_id($stripe_price_id){
        $plans = get_field('plans','options') ?? [];
        $price = '';
        if($plans){
            foreach($plans as $plan){
                if($plan['stripe_price_id'] == $stripe_price_id){
                    $price = $plan['price'];
                }
            }
        }

        return $price;

    }

}