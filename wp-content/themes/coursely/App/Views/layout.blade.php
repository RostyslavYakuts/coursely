{{-- layout.blade.php --}}
@php
    use coursely\App\Core\Helpers\SeoHelper;
    use coursely\App\Core\OptionsData
@endphp
        <!DOCTYPE html>
<html @php language_attributes(); @endphp class="h-full">
<head>
    <meta charset="utf-8">
    <title>{{ SeoHelper::seo_title() }}</title>
    @include('global.header.favicons')
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="True">
    <meta name="viewport" content="initial-scale=1.0, width=device-width user-scalable=yes  viewport-fit=cover">
    <meta name="google-site-verification" content="e43k2m_4IYRCD6iZlY0jFb0NoqiVWEsBpo6fD8S3F8s" />
    @php wp_head(); @endphp
</head>
<body @php body_class('h-full bg-brand-gray') @endphp >

<main class="total-wrapper min-h-full">

    @include('global.header.total-header', ['options' => OptionsData::get_header_data() ?? []])

    @yield('content')
</main>
@include('global.footer.footer',['options' => OptionsData::get_footer_data() ?? []])
</body>
</html>