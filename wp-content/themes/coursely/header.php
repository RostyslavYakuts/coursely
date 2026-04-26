<?php ?>
<!DOCTYPE html>
<html <?php language_attributes();?> class="h-full">
<head>
    <meta charset="utf-8">
    <title><?php SeoHelper::seo_title() ?></title>
    <?php get_template_part('favicons'); ?>
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="True">
    <meta name="viewport" content="initial-scale=1.0, width=device-width user-scalable=yes  viewport-fit=cover">
    <meta name="google-site-verification" />
    <?php wp_head(); ?>
</head>
<body <?php body_class('h-full bg-white text-slate-800') ?> >

<main class="total-wrapper min-h-full">

    <?php get_template_part('global.header.total-header', ['options' => OptionsData::get_header_data() ?? []]); ?>

