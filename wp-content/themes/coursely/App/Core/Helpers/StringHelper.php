<?php

namespace coursely\App\Core\Helpers;

class StringHelper
{
    public static function getInitials(string $name): string {
        $parts = preg_split('/\s+/', trim($name));
        $initials = '';
        foreach ($parts as $p) {
            $initials .= mb_strtoupper(mb_substr($p, 0, 1));
        }
        return $initials;
    }
}