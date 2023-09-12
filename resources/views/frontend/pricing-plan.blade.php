@extends('frontend.layouts.master')
@section('title', 'About Us')
@section('breadcrumb')
@endsection
@section('styles')
    @livewireStyles
@endsection
@section('content')
    <!--============= Counter Section Starts Here =============-->
    <div class="counter-section padding-top" style="margin-top:5%;">
        <div class="container">
               <h3 class="mb-30"> Pricing Plan </h3>
            <div class="row justify-content-center mb-30-none">

                @foreach ($subscription_plan as $plan_data)

                <div class="col-sm-6 col-lg-3">
                    <div class="counter-item">
                        <h3 class="counter-header">
                            <span class="title">{{ $plan_data['name'] }}</span> <br/>
                        </h3>  <h3 class="counter-header">
                            <span class="title counter">{{ $plan_data['fees'] != "0" ? $plan_data['fees'] : "0" }}</span>
                        </h3>
                        <p>Buying Service: {{ $plan_data['no_of_buy_req'] != "0" ? $plan_data['no_of_buy_req'] : "0" }}</p>
                        <p>Selling Service: {{ $plan_data['no_of_sell_req'] != "0" ? $plan_data['no_of_sell_req'] : "0" }}</p>
                        <p>Quotation Service: {{ $plan_data['no_of_quot_req'] != "0" ? $plan_data['no_of_quot_req'] : "0" }}</p>
                        <p>Advertising Service: {{ $plan_data['no_of_adver_req'] != "0" ? $plan_data['no_of_adver_req'] : "0" }}</p>
                        <p>Month: {{ $plan_data['no_of_month'] != "0" ? $plan_data['no_of_month'] : "0" }}</p>
                        <p>Fees: {{ $plan_data['fees'] != "0" ? $plan_data['fees'] : "Free" }} </p>
                         {{-- <button class="btn btn-info btn-small">  {{ $plan_data['fees'] === "0" ? "Free Trial" : "Try Now" }}  </button> --}}
                        @if (Auth::check()) 
                            @if ($plan_data['user_type'] == 'CUSTOMER' && Auth::user()->user_type == 1)
                                 <button type="submit" class="btn btn-info btn-small">  Try Now </button>
                            @elseif ($plan_data['user_type'] == 'SUPPLIER' && Auth::user()->user_type == 2)
                                <button type="disabled" class="btn btn-info btn-small">  Try Now </button>
                            @endif
                        @endif

                    </div>
                </div>

                @endforeach

     {{--            <div class="col-sm-6 col-lg-3">
                    <div class="counter-item">
                        <h3 class="counter-header">
                            <span class="title">Standard</span> <br/>
                        </h3>  <h3 class="counter-header">
                            <span class="title counter">100</span>
                        </h3>
                        <p>Buying Service: 30</p>
                        <p>Selling Service: 20</p>
                        <p>Quotation Service: 10</p>
                        <p>Advertising Service: 5</p>
                        <p>Month: 6</p>
                        <p>Fees: 100 </p>
                         <button class="btn btn-info btn-small"> Try Now </button>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="counter-item">
                        <h3 class="counter-header">
                            <span class="title">Platinum</span> <br/>
                        </h3>  <h3 class="counter-header">
                            <span class="title counter">150</span>
                        </h3>
                        <p>Buying Service: 60</p>
                        <p>Selling Service: 35</p>
                        <p>Quotation Service: 25</p>
                        <p>Advertising Service: 10</p>
                        <p>Month: 9</p>
                        <p>Fees: 150 </p>
                         <button class="btn btn-info btn-small"> Try Now  </button>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="counter-item">
                        <h3 class="counter-header">
                            <span class="title">Premium</span> <br/>
                        </h3>  <h3 class="counter-header">
                            <span class="title counter">250</span>
                        </h3>
                        <p>Buying Service: 100</p>
                        <p>Selling Service: 80</p>
                        <p>Quotation Service: 70</p>
                        <p>Advertising Service: 30</p>
                        <p>Month: 12</p>
                        <p>Fees: 250 </p>
                         <button class="btn btn-info btn-small"> Try Now  </button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!--============= Counter Section Ends Here =============-->


    <!--============= Overview Section Starts Here =============-->
    <section class="overview-section padding-top">
        <div class="container mw-lg-100 p-lg-0">
{{--             <div class="row m-0">
                <div class="col-lg-6 p-0">
                    <div class="overview-content">
                        <div class="section-header text-lg-left">
                            <h2 class="title">What can you expect?</h2>
                            <p>Voluptate aut blanditiis accusantium officiis expedita dolorem inventore odio reiciendis obcaecati quod nisi quae</p>
                        </div>
                        <div class="row mb--50">
                            <div class="col-sm-6">
                                <div class="expert-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/overview/01.png') }}" alt="overview">
                                    </div>
                                    <div class="content">
                                        <h6 class="title">Real-time Auction</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="expert-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/overview/02.png') }}" alt="overview">
                                    </div>
                                    <div class="content">
                                        <h6 class="title">Supports Multiple Currency</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="expert-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/overview/03.png') }}" alt="overview">
                                    </div>
                                    <div class="content">
                                        <h6 class="title">Winner Announcement</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="expert-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/overview/04.png') }}" alt="overview">
                                    </div>
                                    <div class="content">
                                        <h6 class="title">Supports Multiple Currency</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="expert-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/overview/05.png') }}" alt="overview">
                                    </div>
                                    <div class="content">
                                        <h6 class="title">Show all bidders history</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="expert-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/overview/06.png') }}" alt="overview">
                                    </div>
                                    <div class="content">
                                        <h6 class="title">Add to watchlist</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pl-30 pr-0">
                    <div class="w-100 h-100 bg_img" data-background="{{ asset('frontend/images/overview/overview-bg.png') }}"></div>
                </div>
            </div> --}}
        </div>
    </section>
    <!--============= Overview Section Ends Here =============-->




@endsection
