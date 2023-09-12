@extends('frontend.layouts.master')
@section('title', 'Home')
@section('content')
    <!--============= Banner Section Starts Here =============-->

{{--
    <section class="banner-section bg_img" data-background="{{ asset('frontend/images/banner/banner-bg-1.png') }}">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-xl-6">
                    <div class="banner-content cl-custom">
                        <h5 class="cate">Next Generation Auction</h5>
                        <h1 class="title"><span class="d-xl-block">Find Your</span> Next Deal!</h1>
                        <p>
                            Online Auction is where everyone goes to shop, sell,and give, while discovering variety and affordability.
                        </p>
                        <a href="{{ route('auctions') }}" class="custom-button yellow btn-large">Get Started</a>
                    </div>
                </div>
                <div class="d-none d-lg-block col-lg-6">
                    <div class="banner-thumb-2">
                        <img src="{{ asset('frontend/images/banner/banner-1.png') }}" alt="banner">
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-shape d-none d-lg-block">
            <img src="{{ asset('frontend/css/img/banner-shape.png') }}" alt="css">
        </div>
    </section> --}}


    <!--============= Banner Section Ends Here =============-->


    <!--============= Car Auction Section Starts Here =============-->
{{--     <section class="car-auction-section padding-bottom pos-rel oh" style="margin-top: 10%;">
        <div class="container">
            <div class="section-header-3">
                <div class="left d-block">
                    <h2 class="title mb-3">{{ __('Banner Ad') }}</h2>
                    <p>Start winning cars with comfort</p>
                </div>
                <a href="#0" class="normal-button">View All</a>
            </div>
            <div class="row justify-content-center mb-30-none">
                <div class="col-sm-10 col-md-6 col-lg-4">
                    <div class="auction-item-2">
                        <div class="auction-thumb">
                            <a href="#"><img src="{{ asset('frontend/images/product/pro-2.jpg') }}" height="200" alt="car"></a>

                        </div>
                        <div class="auction-content">
                            <h6 class="title">
                                <a href="#">Audi A-4 </a>
                            </h6>
                            <div class="text-center">
                                <a href="#0" class="custom-button">view</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-4">
                    <div class="auction-item-2">
                        <div class="auction-thumb">
                            <a href="#"><img src="{{ asset('frontend/images/product/pro-1.jpg') }}" height="200"  alt="car"></a>

                        </div>
                        <div class="auction-content">
                            <h6 class="title">
                                <a href="#"> Rolex Womens Watch </a>
                            </h6>
                            <div class="text-center">
                                <a href="#0" class="custom-button">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-4">
                    <div class="auction-item-2">
                        <div class="auction-thumb">
                            <a href="#"><img src="{{ asset('frontend/images/product/pro-3.jpg') }}" height="200" alt="car"></a>

                        </div>
                        <div class="auction-content">
                            <h6 class="title">
                                <a href="#">Apple Iphone-14</a>
                            </h6>
                            <div class="text-center">
                                <a href="#0" class="custom-button">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--============= Car Auction Section Ends Here =============-->



{{--     <div class="browse-section ash-bg" >
        <div class="browse-slider-section mt--140">
            <div class="container" style="margin-top: 5%;">
                <div class="section-header-2 cl-custom mb-4">
                    <div class="left">
                        <h6 class="title pl-0 w-100"> {{ __('Browse the Categories') }} </h6>
                    </div>
                    <div class="slider-nav">
                        <a href="#0" class="bro-prev"><i class="flaticon-left-arrow"></i></a>
                        <a href="#0" class="bro-next active"><i class="flaticon-right-arrow"></i></a>
                    </div>
                </div>
                <div class="m--15">
                    <div class="browse-slider owl-theme owl-carousel">
                        @foreach($categories as $category)
                        <a href="{{ route('auctionsByCategory', ['category' => $category->slug]) }}" class="browse-item">
                            <img src="{{ $category['icon'] }}" alt="auction">
                            <span class="info">{{ $category->{'name_'.app()->getLocale()} }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
 --}}
        <!--=============  Auction Section Starts Here =============-->
{{--         <section class="car-auction-section padding-bottom padding-top pos-rel oh">
            @foreach($categories as $key => $category)
                @if(!$category->catalogue_with_product_count)
                    @continue
                @endif
            <div class="container mb-5">
                <div class="section-header-3">
                    <div class="left">
                        <div class="thumb">
                            <img src="{{ $category->icon }}" alt="header-icons">
                        </div>
                        <div class="title-area">
                            <h2 class="title">{{ $category->{'name_'.app()->getLocale()} }}</h2>
                            <p>{{ $category->description }}</p>
                        </div>
                    </div>
                    <a href="{{ route('auctionsByCategory', ['category' => $category->slug]) }}" class="normal-button">View All</a>
                </div>
                <div class="row justify-content-center mb-30-none">
                    @if(isset($category->catalogues) && $category->catalogues[0] && $category->catalogues[0]->products)
                        @foreach($category->catalogues[0]->products as $product)
                            <div class="col-sm-10 col-md-6 col-lg-4">
                                @include('frontend.components.auction')
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @endforeach
        </section>   --}}


{{-- //  this code is orignal no bindings with service type added by sabbir accordin to client requirement by november 2022--}}

{{--         <section class="car-auction-section padding-bottom padding-top pos-rel oh">
            <div class="container mb-5">

                <div class="section-header-2 cl-custom mb-4">
                    <div class="left">
                        <h6 class="title pl-0 w-100"> {{ __('Featured Auction') }} </h6>
                    </div>
                </div>
                <div class="row justify-content-center mb-30-none">
                        @foreach($products as $product)
                            <div class="col-sm-10 col-md-6 col-lg-4">
                                @include('frontend.components.auction')
                            </div>
                        @endforeach
                </div>
            </div>
        </section> --}}

  

            <section class="car-auction-section pos-rel oh" style="margin-top:10%;">
                <div class="container mb-5">

                    <div class="section-header-2 cl-custom mb-4">
                        <div class="left">
                            <h4 class="title pl-0 w-100" > {{ __('Featured Auction') }} </h4>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-30-none">
                            @foreach($featured_products as $product)
                                <div class="col-sm-10 col-md-6 col-lg-4">
                                    @include('frontend.components.auction')
                                </div>
                            @endforeach
                    </div>
                </div>
            </section>

     

{{-- // end the modification original code --}}

         <section class="car-auction-section padding-bottom  pos-rel oh">
            <div class="container mb-5">

                <div class="row justify-content-center">
        
                        <h4 class="title pl-0 w-100" > {{ __('Buying Auction') }} </h4>
        
                        @foreach($products as $product)
                           @if ($product->auction->service_type == 1)
                            <div class="col-sm-10 col-md-6 col-lg-4">
                                @include('frontend.components.auction')
                            </div>
                            @endif
                        @endforeach
                </div>                

                <div class="row justify-content-center mb-30-none">

                        <h4 class="title pl-0 w-100" style="margin-top:20px;"> {{ __('Selling Auction') }} </h4>
                 
                        @foreach($products as $product)
                         @if ($product->auction->service_type == 2)
                            <div class="col-sm-10 col-md-6 col-lg-4">
                                @include('frontend.components.auction')
                            </div>
                            @endif
                        @endforeach
                </div>

                <div class="row justify-content-center mb-30-none">
              
                        <h4 class="title pl-0 w-100" style="margin-top:20px;"> {{ __('Quotation Auction') }} </h4>
                
                        @foreach($products as $product)
                         @if ($product->auction->service_type == 3)
                            <div class="col-sm-10 col-md-6 col-lg-4">
                                @include('frontend.components.auction')
                            </div>
                            @endif
                        @endforeach
                </div>

            </div>
        </section>

        <!--============= Car Auction Section Ends Here =============-->
    </div>




    <!--============= Popular Auction Section Starts Here =============-->
    {{-- <section class="popular-auction padding-top pos-rel">
        <div class="popular-bg bg_img" data-background="{{ asset('frontend/images/auction/popular/popular-bg.png') }}"></div>
        <div class="container">
            <div class="section-header cl-custom">
                <span class="cate">Closing Within 24 Hours</span>
                <h2 class="title">Popular Auctions</h2>
                <p>Bid and win great deals,Our auction process is simple, efficient, and transparent.</p>
            </div>
            <div class="popular-auction-wrapper">
                <div class="row justify-content-center mb-30-none">
                    <div class="col-lg-6">
                        <div class="auction-item-3">
                            <div class="auction-thumb">
                                <a href="#"><img src="{{ asset('frontend/images/auction/popular/auction-1.jpg') }}" alt="popular"></a>
                                <a href="#0" class="bid"><i class="flaticon-auction"></i></a>
                            </div>
                            <div class="auction-content">
                                <h6 class="title">
                                    <a href="#">Apple Macbook Pro Laptop</a>
                                </h6>
                                <div class="bid-amount">
                                    <div class="icon">
                                        <i class="flaticon-auction"></i>
                                    </div>
                                    <div class="amount-content">
                                        <div class="current">Current Bid</div>
                                        <div class="amount">$876.00</div>
                                    </div>
                                </div>
                                <div class="bids-area">
                                    Total Bids : <span class="total-bids">130 Bids</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="auction-item-3">
                            <div class="auction-thumb">
                                <a href="#"><img src="{{ asset('frontend/images/auction/popular/auction-2.jpg') }}" alt="popular"></a>
                                <a href="#0" class="bid"><i class="flaticon-auction"></i></a>
                            </div>
                            <div class="auction-content">
                                <h6 class="title">
                                    <a href="#">Canon EOS Rebel T6I
                                        Digital Camera</a>
                                </h6>
                                <div class="bid-amount">
                                    <div class="icon">
                                        <i class="flaticon-auction"></i>
                                    </div>
                                    <div class="amount-content">
                                        <div class="current">Current Bid</div>
                                        <div class="amount">$876.00</div>
                                    </div>
                                </div>
                                <div class="bids-area">
                                    Total Bids : <span class="total-bids">130 Bids</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="auction-item-3">
                            <div class="auction-thumb">
                                <a href="#"><img src="{{ asset('frontend/images/auction/popular/auction-3.jpg') }}" alt="popular"></a>
                                <a href="#0" class="bid"><i class="flaticon-auction"></i></a>
                            </div>
                            <div class="auction-content">
                                <h6 class="title">
                                    <a href="#">14k Gold Geneve Watch,
                                        24.5g</a>
                                </h6>
                                <div class="bid-amount">
                                    <div class="icon">
                                        <i class="flaticon-auction"></i>
                                    </div>
                                    <div class="amount-content">
                                        <div class="current">Current Bid</div>
                                        <div class="amount">$876.00</div>
                                    </div>
                                </div>
                                <div class="bids-area">
                                    Total Bids : <span class="total-bids">130 Bids</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="auction-item-3">
                            <div class="auction-thumb">
                                <a href="#"><img src="{{ asset('frontend/images/auction/popular/auction-4.jpg') }}" alt="popular"></a>
                                <a href="#0" class="bid"><i class="flaticon-auction"></i></a>
                            </div>
                            <div class="auction-content">
                                <h6 class="title">
                                    <a href="#">14K White Gold 185.60
                                        Grams 5.95 Carats</a>
                                </h6>
                                <div class="bid-amount">
                                    <div class="icon">
                                        <i class="flaticon-auction"></i>
                                    </div>
                                    <div class="amount-content">
                                        <div class="current">Current Bid</div>
                                        <div class="amount">$876.00</div>
                                    </div>
                                </div>
                                <div class="bids-area">
                                    Total Bids : <span class="total-bids">130 Bids</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="auction-item-3">
                            <div class="auction-thumb">
                                <a href="#"><img src="{{ asset('frontend/images/auction/popular/auction-5.jpg') }}" alt="popular"></a>
                                <a href="#0" class="bid"><i class="flaticon-auction"></i></a>
                            </div>
                            <div class="auction-content">
                                <h6 class="title">
                                    <a href="#">2009 Toyota Prius
                                        (Medford, NY 11763)</a>
                                </h6>
                                <div class="bid-amount">
                                    <div class="icon">
                                        <i class="flaticon-auction"></i>
                                    </div>
                                    <div class="amount-content">
                                        <div class="current">Current Bid</div>
                                        <div class="amount">$876.00</div>
                                    </div>
                                </div>
                                <div class="bids-area">
                                    Total Bids : <span class="total-bids">130 Bids</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="auction-item-3">
                            <div class="auction-thumb">
                                <a href="#"><img src="{{ asset('frontend/images/auction/popular/auction-6.jpg') }}" alt="popular"></a>
                                <a href="#0" class="bid"><i class="flaticon-auction"></i></a>
                            </div>
                            <div class="auction-content">
                                <h6 class="title">
                                    <a href="#">.6 Gram Pure Gold
                                        Nugget</a>
                                </h6>
                                <div class="bid-amount">
                                    <div class="icon">
                                        <i class="flaticon-auction"></i>
                                    </div>
                                    <div class="amount-content">
                                        <div class="current">Current Bid</div>
                                        <div class="amount">$876.00</div>
                                    </div>
                                </div>
                                <div class="bids-area">
                                    Total Bids : <span class="total-bids">130 Bids</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--============= Popular Auction Section Ends Here =============-->


    <!--============= How Section Starts Here =============-->
    {{-- <section class="how-section padding-top">
        <div class="container">
            <div class="how-wrapper section-bg">
                <div class="section-header text-lg-left">
                    <h2 class="title">How it works</h2>
                    <p>Easy 3 steps to win</p>
                </div>
                <div class="row justify-content-center mb--40">
                    <div class="col-md-6 col-lg-4">
                        <div class="how-item">
                            <div class="how-thumb">
                                <img src="{{ asset('frontend/images/how/how1.png') }}" alt="how">
                            </div>
                            <div class="how-content">
                                <h4 class="title">Sign Up</h4>
                                <p>No Credit Card Required</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="how-item">
                            <div class="how-thumb">
                                <img src="{{ asset('frontend/images/how/how2.png') }}" alt="how">
                            </div>
                            <div class="how-content">
                                <h4 class="title">Bid</h4>
                                <p>Bidding is free Only pay if you win</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="how-item">
                            <div class="how-thumb">
                                <img src="{{ asset('frontend/images/how/how3.png') }}" alt="how">
                            </div>
                            <div class="how-content">
                                <h4 class="title">Win</h4>
                                <p>Fun - Excitement - Great deals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--============= How Section Ends Here =============-->


@endsection
@section('scripts')
    <script src="{{ asset('frontend/js/yscountdown.min.js') }}"></script>
@endsection
