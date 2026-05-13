<?php

namespace coursely\App\Core\Helpers;

class UserIpDetector
{
    public static function detect(){
        if ( ! empty($_SERVER['HTTP_CLIENT_IP']) ) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        if ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        }
        return $_SERVER['REMOTE_ADDR'] ?? '';
    }
}