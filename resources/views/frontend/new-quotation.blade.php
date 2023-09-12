@extends('frontend.layouts.master')
@section('title', 'New Quotation')
@section('breadcrumb')
    {{ Breadcrumbs::render('dashboard') }}
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
    <!--============= Dashboard Section Starts Here =============-->
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="row justify-content-center">

{{--                 @include('frontend.layouts.sidebar') --}}

                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="dash-pro-item mb-30 dashboard-widget">
                                <div class="header">
                                    <h4 class="title">{{ __('New Quotation') }} </h4>
                                </div>
                                @livewire('new-quotation')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= Dashboard Section Ends Here =============-->
@endsection
@section('scripts')
    @livewireScripts
@endsection