<?php

namespace coursely\App\Core\CPT;

class CPTRegistrar
{
    public function __construct()
    {
        add_action('init', [$this, 'register']);
    }
    public function register(): void
    {
        new CustomPostType(
            'Contact',
            'contact',
            'dashicons-admin-page',
            false,
            false,
            ['title']
        );
        new CustomPostType(
            'Service',
            'service',
            'dashicons-list-view',
            false,
            true,
            ['title','editor','excerpt','thumbnail']
        );

    }
}