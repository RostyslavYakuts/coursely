<?php

use coursely\acf\FieldsKeeper;
use coursely\App\Core\Bootstrap;

if (!defined('ABSPATH')) {
    exit;
}

// 🔒 ACF Pro
if (!class_exists('ACF')) {

    add_action('admin_notices', function () {

        $missing = [];

        if (!class_exists('ACF')) {
            $missing[] = 'ACF Pro';
        }

        echo '<div class="notice notice-error"><p><strong>Error:</strong> Theme requires <strong>'
            . implode(', ', $missing) .
            '</strong>. Please activate required plugin(s).</p></div>';
    });

    add_action('template_redirect', function () {

        wp_die(
            '<h1>Required plugins not activated</h1>
             <p>This theme requires ACF Pro.</p>',
            'Missing plugins',
            ['response' => 503]
        );

    });

    return;
}

define('IMAGES_PATH', get_template_directory_uri() . '/assets/dist/images/');
define('EMAIL_PATH', get_template_directory() . '/assets/dist/email/');
define('FAVICONS_PATH', get_template_directory_uri() . '/assets/dist/images/favicons/');

require_once __DIR__ . '/vendor/autoload.php';

try {
    new FieldsKeeper();
    Bootstrap::init();
} catch (Throwable $e) {
    add_action('template_redirect', function() use ($e) {
        wp_die(
            '<h1>Theme init error</h1><p>' . esc_html($e->getMessage()) . '</p>',
            'Theme error',
            ['response' => 500]
        );
    });
}