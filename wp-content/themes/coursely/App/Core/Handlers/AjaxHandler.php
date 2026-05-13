<?php
namespace coursely\App\Core\Handlers;


use coursely\App\Core\Helpers\NonceChecker;
use coursely\App\Core\Helpers\RecaptchaChecker;
use coursely\App\Core\Helpers\UserIpDetector;
use coursely\App\Core\Services\EmailSender;

class AjaxHandler
{
    public function __construct(){
        add_action('wp_ajax_nopriv_contact_us_form_action', [$this, 'contact_us_form_action']);
        add_action('wp_ajax_contact_us_form_action', [$this, 'contact_us_form_action']);
    }

    public function contact_us_form_action(): void
    {
		 $ip = UserIpDetector::detect();
		 $key = 'contact_form_' . md5($ip);

		 if (get_transient($key)) {
			 wp_send_json_error(['message' => '<h3 class="text-[24px] font-bold">Not so fast!</h3> <span>Try again latter)</span>']);
		 }

		 set_transient($key, 1, 120);

		 // Check nonce
        NonceChecker::check('contact_us_form_action');

        // Sanitize input
		 $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
		 $subject = isset($_POST['subject']) ? sanitize_text_field(wp_unslash($_POST['subject'])) : '';
		 $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
		 $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

		  if (!empty($_POST['company'])) {
			 wp_send_json_error(['message' => '<h3 class="text-[24px] font-bold">Warning!</h3> <span>Spam.</span>']);
		  }

        // Validate required fields
        if ( strlen($name) < 2  || !is_email($email) || strlen($subject) < 3 ) {
            wp_send_json_error([
                'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">Please</h3> <span class="block mt-[12px]">fill out all fields correctly.</span>'
            ]);
        }

        // Validate reCAPTCHA (v3)
        RecaptchaChecker::check();

        // Store user data
        $post_id = wp_insert_post([
            'post_type'   => 'contact',
            'post_title'  => 'Info from '.$email,
            'post_status' => 'publish',
        ], true);

        if ($post_id) {
            update_post_meta($post_id, 'name',$name);
            update_post_meta($post_id, 'email',$email);
            update_post_meta($post_id, 'subject',$subject);
            update_post_meta($post_id, 'message',$message);
            update_post_meta($post_id, 'date',date_i18n( 'm/d/Y h:i a', current_time( 'timestamp' ) ) );
        }
        // Send email
        $admin_email = get_field('admin_email','options') ?? '';
        $name = $name ?? 'User without name';
        $sent = EmailSender::send_data( [
            'user_name'=>$name,
            'user_email'=>$email,
            'user_message'=>$message
        ], $admin_email);

        if (!$sent) {
            wp_send_json_error([
                'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">Failed to send email!</h3> <span class="block mt-[12px]">Please try again later.</span>'
            ]);
        }

        wp_send_json_success([
            'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">'.__('Thank you','coursely').'</h3> <span class="block mt-[12px]">'.__('Your message has been sent successfully.','coursely').'</span>'
        ]);
    }

}