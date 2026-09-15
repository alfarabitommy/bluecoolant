<!DOCTYPE html>
{{-- <html lang="{{get_user_lang()}}" dir="{{get_user_lang_direction()}}"> --}}
<html lang="{{get_user_lang()}}">
<head>
    @if(!empty(get_static_option('site_google_analytics')))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{get_static_option('site_google_analytics')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', "{{get_static_option('site_google_analytics')}}");
    </script>
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <meta name="description" content="{{get_static_option('site_meta_description')}}"> -->

    @yield('meta-name')

    <meta name="tags" content="{{get_static_option('site_meta_tags')}}">
    {!! render_favicon_by_id(get_static_option('site_favicon')) !!}

    <!-- load fonts dynamically -->
    {{-- {!! load_google_fonts() !!} --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    {{-- Material Symbols --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols" rel="stylesheet" />
    <!-- all stylesheets -->
    <link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/dynamic-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/customize.css')}}">
    <link rel="stylesheet" href="{{asset('@core/public/css/app.css') }}">
    <style>
        :root {
            --main-color-one: {{get_static_option('site_color')}};
            --secondary-color: {{get_static_option('site_main_color_two')}};
        }
    </style>
    @yield('style')

        {{-- @if(get_user_lang_direction() === 'rtl')
            <link rel="stylesheet" href="{{asset('assets/frontend/css/rtl.css')}}">
        @endif --}}

    @if(request()->is('blog/*') || request()->is('work/*') || request()->is('service/*'))
    @yield('og-meta')
    <title>@yield('site-title')</title>
    @elseif(request()->is('about') || request()->is('service') || request()->is('work') || request()->is('team') || request()->is('faq') || request()->is('blog') || request()->is('contact') || request()->is('p/*'))
    <title>@yield('site-title') - {{get_static_option('site_'.get_user_lang().'_title')}} </title>
    @else
    <title>{{get_static_option('site_'.get_user_lang().'_title')}} - {{get_static_option('site_'.get_user_lang().'_tag_line')}}</title>
    @endif

    @yield('schema')
    <link rel="canonical" href="<?php echo (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
</head>
<body>
@if(!empty(get_static_option('home_page_support_bar_section_status')))
@include('frontend.partials.support')
@endif
