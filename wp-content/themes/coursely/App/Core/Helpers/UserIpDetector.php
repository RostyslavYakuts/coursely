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
    public static function get_client_ip(): string
    {
        // Ordered list of server vars to check, most-specific first.
        $candidates = array(
            'HTTP_CF_CONNECTING_IP',  // Cloudflare strips and re-sets this header.
            'HTTP_X_REAL_IP',         // Nginx real_ip_module.
            'HTTP_X_FORWARDED_FOR',   // Standard proxy chain — may be comma-separated.
            'REMOTE_ADDR',            // Raw TCP connection — final fallback.
        );

        $ip = '127.0.0.1';

        foreach ( $candidates as $header ) {
            if ( empty( $_SERVER[ $header ] ) ) {
                continue;
            }
            // X-Forwarded-For can contain a comma-separated list; the first entry is the client.
            $candidate = trim( current( explode( ',', sanitize_text_field( wp_unslash( $_SERVER[ $header ] ) ) ) ) );
            if ( filter_var( $candidate, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
                $ip = $candidate;
                break;
            }
        }

        // Final fallback: if all candidates were private/reserved ranges (e.g. local dev),
        // accept REMOTE_ADDR without the public-IP restriction.
        if ( $ip === '127.0.0.1' && ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
        }

        /**
         * Filter the resolved client IP address.
         *
         * @param string $ip The detected IP address.
         */
        return (string) apply_filters( 'strp_sub_client_ip', $ip );
    }
}