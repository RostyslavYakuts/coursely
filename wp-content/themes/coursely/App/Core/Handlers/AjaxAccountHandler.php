<?php
namespace coursely\App\Core\Handlers;

class AjaxAccountHandler
{
    public function __construct(){
        add_action('wp_ajax_profile_settings_edit_action', [$this, 'profile_settings_edit_action']);
        add_action('wp_ajax_password_edit_action', [$this,'password_edit_action']);
    }

    public function profile_settings_edit_action(): void
    {
        $user_id = get_current_user_id();

        if (!$user_id) {
            wp_send_json_error([
                'message' => 'Unauthorized'
            ]);
        }

        $first_name = sanitize_text_field($_POST['user_first_name'] ?? '');
        $last_name  = sanitize_text_field($_POST['user_last_name'] ?? '');
        $email      = sanitize_email($_POST['user_email'] ?? '');

        wp_update_user([
            'ID'         => $user_id,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'user_email' => $email,
        ]);

        if (!empty($_FILES['user_photo']['name'])) {

            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $file = $_FILES['user_photo'];

            // check mime type
            $file_type = wp_check_filetype_and_ext(
                $file['tmp_name'],
                $file['name']
            );

            $allowed_mimes = [
                'jpg|jpeg|jpe' => 'image/jpeg',
                'png'          => 'image/png',
                'gif'          => 'image/gif',
                'webp'         => 'image/webp',
            ];

            if (
                empty($file_type['type']) ||
                !in_array($file_type['type'], $allowed_mimes, true)
            ) {
                wp_send_json_error([
                    'message' => 'Invalid image type'
                ]);
            }

            // additional real image check
            if (!getimagesize($file['tmp_name'])) {
                wp_send_json_error([
                    'message' => 'File is not an image'
                ]);
            }

            $attachment_id = media_handle_upload('user_photo', 0);

            if (is_wp_error($attachment_id)) {
                wp_send_json_error([
                    'message' => $attachment_id->get_error_message()
                ]);
            }

            update_field(
                'user_photo',
                $attachment_id,
                'user_' . $user_id
            );
        }

        wp_send_json_success([
            'message' => 'Profile updated'
        ]);
    }

    public function password_edit_action(): void
    {
        check_ajax_referer(
            'password_edit_action',
            'nonce'
        );

        if (!is_user_logged_in()) {
            wp_send_json_error([
                'message' => __('Unauthorized', 'coursely')
            ]);
        }

        $user_id = get_current_user_id();

        $current_password = $_POST['user_current_password'] ?? '';
        $new_password = $_POST['user_new_password'] ?? '';
        $repeat_password = $_POST['user_repeat_new_password'] ?? '';

        if (
            empty($current_password) ||
            empty($new_password) ||
            empty($repeat_password)
        ) {
            wp_send_json_error([
                'message' => __('All fields are required', 'coursely')
            ]);
        }

        if ($new_password !== $repeat_password) {
            wp_send_json_error([
                'message' => __('Passwords do not match', 'coursely')
            ]);
        }

        if (strlen($new_password) < 8) {
            wp_send_json_error([
                'message' => __('Password must contain at least 8 characters', 'coursely')
            ]);
        }

        $user = get_userdata($user_id);

        // WP standard password verification
        if (!wp_check_password(
            $current_password,
            $user->user_pass,
            $user_id
        )) {
            wp_send_json_error([
                'message' => __('Current password is incorrect', 'coursely')
            ]);
        }

        // update password securely
        wp_set_password(
            $new_password,
            $user_id
        );

        // keep user logged in
        wp_set_auth_cookie($user_id);

        wp_send_json_success([
            'message' => __('Password updated successfully', 'coursely')
        ]);
    }

}