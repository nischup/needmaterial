@extends('layouts.guest')
@section('title', __('User Registration'))
@section('breadcrumb')
    {{ Breadcrumbs::render('register') }}
@endsection
@section('styles')
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #bccaea;
            border-radius: unset;
            text-align: left;
        }

        .select2-container .select2-selection--single {
            height: 50px;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 25px;
            padding-top: 10px
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px
        }
    </style>
@endsection
@section('content')
    <section class="account-section padding-bottom">
        <div class="container">
            <div class="account-wrapper mt--100 mt-lg--440">
                <div class="left-side">
                    <div class="section-header">

                        @include('components.auth-pages-lang-switcher')

                        <h2 class="title">{{ __('SIGN UP') }}</h2>
                        <p>{{ __('We\'re happy you\'re here!') }}</p>
                    </div>
                    <div class="or">
                        <span>{{ __('NEW USER - REGISTRATION') }}</span>
                    </div>
                    @livewire('user-register')
                </div>
                <div class="right-side cl-white">
                    <div class="section-header mb-0">
                        <h3 class="title mt-0">ALREADY HAVE AN ACCOUNT?</h3>
                        <p>Log in and go to your Dashboard.</p>
                        <a href="{{ route('login') }}" class="custom-button transparent">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @livewireScripts
@endsection
