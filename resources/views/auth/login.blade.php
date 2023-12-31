@extends('layouts.guest')
@section('title', __('User Login'))
@section('breadcrumb')
    {{ Breadcrumbs::render('login') }}
@endsection
@section('content')
    <section class="account-section padding-bottom">
        <div class="container">
            <div class="account-wrapper mt--100 mt-lg--440">
                <div class="left-side" style="padding-top: 20px">
                    <div class="section-header">

                        @include('components.auth-pages-lang-switcher')

                        <h2 class="title">{{ __('HI, THERE') }}</h2>
                        <p>{{ __('You can log in to your account here.') }}</p>
                    </div>
                    @livewire('user-login')
                </div>
                <div class="right-side cl-white">
                    <div class="section-header mb-0">
                        <h3 class="title mt-0">{{ __('NEW HERE?') }}</h3>
                        <p>{{ __('Sign up and create your Account') }}</p>
                        <a href="{{ route('register') }}" class="custom-button transparent">{{ __('Sign Up') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
