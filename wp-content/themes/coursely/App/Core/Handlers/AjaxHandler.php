<?php
namespace coursely\App\Core\Handlers;


use coursely\App\Core\Services\EmailSender;

class AjaxHandler
{
    public function __construct(){
        add_action('wp_ajax_nopriv_contact_us_form_action', [$this, 'contact_us_form_action']);
        add_action('wp_ajax_contact_us_form_action', [$this, 'contact_us_form_action']);
    }

    public function contact_us_form_action(): void
    {
		 $ip = $_SERVER['REMOTE_ADDR'] ?? '';
		 $key = 'contact_form_' . md5($ip);

		 if (get_transient($key)) {
			 wp_send_json_error(['message' => '<h3 class="text-[24px] font-bold">Not so fast!</h3> <span>Try again latter)</span>']);
		 }

		 set_transient($key, 1, 120);

		 // Check nonce
        if (empty($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'contact_us_form_action')) {
            wp_send_json_error([
                'message' => '<h3 class="text-[24px] font-bold">Warning!</h3> <span>Security check failed.</span>'
            ]);
        }

        $file_check = $this->validate_file($_FILES);
        if (!$file_check['valid']) {
            wp_send_json_error([
                'message' => $file_check['message']
            ]);
        }




        // Sanitize input
		 $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
		 $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
		 $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
		 $token = isset($_POST['recaptcha_token']) ? sanitize_text_field(wp_unslash($_POST['recaptcha_token'])) : '';

		  if (!empty($_POST['company'])) {
			 wp_send_json_error(['message' => '<h3 class="text-[24px] font-bold">Warning!</h3> <span>Spam.</span>']);
		  }

        // Validate required fields
        if ( strlen($name) < 2  || !is_email($email) || strlen($message) < 10) {
            wp_send_json_error([
                'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">Please</h3> <span class="block mt-[12px]">fill out all fields correctly.</span>'
            ]);
        }

        // Validate reCAPTCHA (v3)
        $secret_key = get_field('recaptcha_secret_key', 'option');
        $use_recaptcha = get_field('use_recaptcha', 'option');
        $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => $secret_key,
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
					 'timeout' => 5
            ],
        ]);

        if (is_wp_error($response) && $use_recaptcha) {
            wp_send_json_error([
                'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">reCAPTCHA</h3> <span class="block mt-[12px]">request failed.</span>'
            ]);
        }

        $result = json_decode(wp_remote_retrieve_body($response), true);
        if ($use_recaptcha && (empty($result['success']) || $result['score'] < 0.7)) {
            wp_send_json_error([
                'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">reCAPTCHA</h3> <span class="block mt-[12px]">verification failed.</span> '
            ]);
        }
        // Store user data
        $post_id = wp_insert_post([
            'post_type'   => 'contact',
            'post_title'  => 'Info from '.$email,
            'post_status' => 'publish',
        ], true);
        $file_path = null;
        if ($post_id) {
            if ($file_check['valid'] && !empty($file_check['file'])) {
                $file_result = $this->handle_uploaded_file($file_check['file'], $post_id);
                if ($file_result['attach_id']) {
                    update_field('file', $file_result['attach_id'], $post_id);
                    $file_path = $file_result['file_path']; // pass to email
                }
            }
            update_post_meta($post_id, 'name',$name);
            update_post_meta($post_id, 'email',$email);
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
            'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">'.__('Thank you','ws').'</h3> <span class="block mt-[12px]">'.__('Your message has been sent successfully.','ws').'</span>'
        ]);
    }
    private function validate_file(array $files): array
    {
        if (
            empty($files['user_file']) ||
            $files['user_file']['error'] === UPLOAD_ERR_NO_FILE
        ) {
            return [
                'valid' => true,
                'message' => 'ok',
                'file' => null
            ];
        }

        $file = $files['user_file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [
                'valid' => false,
                'message' => '<h3 class="text-[24px] font-bold">Warning!</h3> <span>File upload error.</span>',
                'file' => null
            ];
        }
        $allowed_mimes = [
            'text/plain',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg',
            'image/png',
            'application/pdf',
            'application/octet-stream',   // fallback for .doc
            'application/x-ole-storage',
        ];
        $max_size = 2 * 1024 * 1024;

        // real mime detection
        $check_file_type_ext = wp_check_filetype_and_ext(
            $file['tmp_name'],
            $file['name']
        );
        if (!$check_file_type_ext) {
            return [
                'valid' => false,
                'message' => '<h3 class="text-[24px] font-bold">Warning!</h3><span>Invalid file type.</span>',
                'file' => null
            ];
        }
        $allowed_types = [ 'text/plain', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($file['type'], $allowed_types, true)) {
            return [
                'valid' => false,
                'message' => '<h3 class="text-[24px] font-bold">Warning!</h3> <span>Invalid file type. Only TXT, JPG, PNG, PDF allowed.</span>',
                'file' => null
            ];
        }

        if ($file['size'] > $max_size) {
            return [
                'valid' => false,
                'message' => '<h3 class="text-[24px] font-bold">Warning!</h3> <span>File size exceeds 2MB limit.</span>',
                'file' => null
            ];
        }

        return [
            'valid' => true,
            'message' => 'ok',
            'file' => $file
        ];
    }
    private function handle_uploaded_file(array $file, int $post_id): array
    {
        if(!$file){
            return[];
        }
        $result = [
            'attach_id' => null,
            'file_path' => null,
        ];

        if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return $result;
        }

		 $allowed_ext = ['txt','doc','jpg','png','pdf'];
		 $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

		 if (!in_array($ext, $allowed_ext, true)) {
			 return $result;
		 }

        $upload = wp_upload_dir();
        $target_dir = trailingslashit($upload['path']);
        $filename = wp_unique_filename($target_dir, sanitize_file_name($file['name']));
        $target_file = $target_dir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            return $result;
        }

        $file_url = trailingslashit($upload['url']) . $filename;
        $filetype = wp_check_filetype(basename($target_file), null);

        $attachment = [
            'guid'           => $file_url,
            'post_mime_type' => $filetype['type'],
            'post_title'     => sanitize_file_name($file['name']),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ];

        $attach_id = wp_insert_attachment($attachment, $target_file, $post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $target_file);
        wp_update_attachment_metadata($attach_id, $attach_data);

        $result['attach_id'] = $attach_id;
        $result['file_path'] = $target_file;

        return $result;
    }

}