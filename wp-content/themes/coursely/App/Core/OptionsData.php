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
            'admin_phone'  => get_field('admin_phone', 'options'),
            'admin_email'  => get_field('admin_email', 'options'),
        ];
    }

    public static function get_global_faq_data():array
    {
        return[
            'faq_title' => get_field('faq_title', 'options') ?? '',
            'faq_description' => get_field('faq_description', 'options') ?? '',
            'faq' => get_field('faq', 'options') ?? [],
        ];
    }

    public static function get_footer_data():array
    {
        return[

            'footer_banner_title' => get_field('footer_banner_title', 'options') ?? '',
            'footer_banner_description' => get_field('footer_banner_description', 'options') ?? '',
            'footer_banner_cta' => get_field('footer_banner_cta', 'options') ?? '',
            'footer_banner_cta_link' => get_field('footer_banner_cta_link', 'options') ?? '',
            'footer_contacts_text' => get_field('footer_contacts_text', 'options') ?? '',

            'logo'        => get_field('footer_logo', 'options') ?? [],
            'admin_email'   => get_field('admin_email', 'options'),
            'admin_phone'   => get_field('admin_phone', 'options'),

        ];
    }




}
