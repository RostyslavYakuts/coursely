<?php
namespace coursely\App\Core\Services;


if (!defined('ABSPATH')) {
    exit;
}
class EmailSender
{

    public static function send_data(array $sending_data, string $contact): bool
    {
        $html = file_get_contents(EMAIL_PATH . 'email.html');
        $src = IMAGES_PATH;
        $name = $sending_data['user_name'] ?: 'there';
        $user_email = $sending_data['user_email'];
        $user_message = $sending_data['user_message'];
        $year = Date('Y');

        $subject = 'From coursely.com';
        $message = "
        <h3>New contact request</h3>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$user_email}</p>
        <p><strong>Message:</strong><br>{$user_message}</p>
        ";
        $html = str_replace(['{{src}}','{{name}}','{{email}}','{{year}}'], [
            $src,
            $name,
            $user_email,
            $year
        ], $html);
        $headers = self::getEmailHeaders();
        wp_mail($contact, $subject, $message, $headers);
        return wp_mail($user_email, $subject, $html, $headers);

    }
    /**
     * Get standardized email headers
     *
     * @return string
     */
    protected static function getEmailHeaders(): string
    {
        $headers = "From: coursely.com <admin@coursely.com>\r\n";
        $headers .= "Reply-To: No reply\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf8\r\n";
        return $headers;
    }
}