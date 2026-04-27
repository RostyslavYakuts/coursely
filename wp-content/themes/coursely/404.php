<?php
// 404 Template

use coursely\App\Controllers\Error404Controller;

if (!defined('ABSPATH')) {
    exit;
}

(new Error404Controller())->render();