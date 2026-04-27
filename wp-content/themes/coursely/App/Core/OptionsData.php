<?php

namespace coursely\App\Core;
class OptionsData
{

	public static function get_recaptcha_data():array
	{
      return  [
                'public'  => get_field('recaptcha_public_key', 'options'),
                'secret'  => get_field('recaptcha_secret_key', 'options'),
                'enabled' => get_field('use_recaptcha', 'options')
        ];

	}

    public static function get_header_data():array{
        return [
            'login_popup_image' => get_field('login_popup_image', 'options')??[],
            'header_logo' => get_field('header_logo', 'options')??[],
            'header_cta_text' => get_field('header_cta_text', 'options'),
            'header_cta_link'  => get_field('header_cta_link', 'options'),
            'admin_phone'  => get_field('admin_phone', 'options'),
            'admin_email'  => get_field('admin_email', 'options'),
        ];
    }

    public static function get_footer_data():array
    {
        return[

            'footer_title' => get_field('footer_title', 'options') ?? '',
            'footer_description' => get_field('footer_description', 'options') ?? '',
            'logo'        => get_field('footer_logo', 'options') ?? [],
            'copyright'   => get_field('copyright_text', 'options'),
            'admin_email'   => get_field('admin_email', 'options'),
            'admin_phone'   => get_field('admin_phone', 'options'),
            'footer_socials'=> get_field('footer_socials', 'options') ?? [],
            'cookies' => [
                'cookies_title' => get_field('cookies_title', 'options'),
                'cookies_description' => get_field('cookies_description', 'options'),
            ]
        ];
    }
	public static function get_integrated_data():array
	{
      return [
            'recaptcha' => [
                'public'  => get_field('recaptcha_public_key', 'options'),
                'secret'  => get_field('recaptcha_secret_key', 'options'),
                'enabled' => get_field('use_recaptcha', 'options'),
            ],
            'header' => [
                'header_logo'   => get_field('header_logo', 'options'),
                'cta'    => [
                    'text' => get_field('cta_button_text', 'options'),
                    'url'  => get_field('cta_button_url', 'options'),
                ],
            ],
            'footer' => [
                'logo'        => get_field('footer_logo', 'options'),
                'copyright'   => get_field('copyright_text', 'options'),
                'banner' => [
                    'title'       => get_field('banner_title', 'options'),
                    'description' => get_field('banner_description', 'options'),
                    'background'  => get_field('banner_background_image', 'options'),
                ],
            ],
        ];

	}




}
