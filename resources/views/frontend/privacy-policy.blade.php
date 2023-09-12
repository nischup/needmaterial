@extends('frontend.layouts.master')
@section('title', 'Privacy Policy')
@section('breadcrumb')
    {{ Breadcrumbs::render('about-us') }}
@endsection
@section('styles')
    @livewireStyles
@endsection
@section('content')

    <!--============= About Section Starts Here =============-->
    <section class="about-section">
        <div class="container">
            <div class="about-wrapper mt--100 mt-lg--440 padding-top">
                <div class="row">
                    <div class="col-lg-12 col-xl-6">
                        @if (isset($page_data->page_details))
                            <div class="about-content">
                                <h4 class="subtitle">Privacy Policy</h4>
                                <p> {{ $page_data->page_details }} </p>
                            </div>
                            @else
                          <p> Sorry !!! No Data Available </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= About Section Ends Here =============-->



    <!--============= Client Section Starts Here =============-->
    <section class="client-section padding-top padding-bottom">
        <div class="container">
        </div>
    </section>
    <!--============= Client Section Ends Here =============-->
@endsection
