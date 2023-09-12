@extends('frontend.layouts.master')
@section('title', 'Catalogue')
@section('breadcrumb')
    {{ Breadcrumbs::render('dashboard') }}
@endsection
@section('styles')
    @livewireStyles
@endsection
@section('content')
    <!--============= Dashboard Section Starts Here =============-->
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="row justify-content-center">

                @include('frontend.layouts.sidebar')

                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="dash-pro-item mb-30 dashboard-widget">
                                @livewire('catalogue')
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
