<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>@yield('title') | {{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/owl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">

        <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">

        @yield('styles')

        @stack('styles')
    </head>
    <body>
        <!--============= ScrollToTop Section Starts Here =============-->
        <div class="overlayer" id="overlayer">
            <div class="loader">
                <div class="loader-inner"></div>
            </div>
        </div>
        <a href="#0" class="scrollToTop"><i class="fas fa-angle-up"></i></a>
        <div class="overlay"></div>
        <!--============= ScrollToTop Section Ends Here =============-->

        @include('frontend.layouts.nav')

        @yield('breadcrumb')

        @yield('content')

        @include('frontend.layouts.footer')

        @include('frontend.layouts.scripts')

        @yield('scripts')

        @livewireScripts
    </body>
</html>
