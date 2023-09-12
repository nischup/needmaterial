@extends('frontend.layouts.master')
@if(isset($category))
    @section('title', $category->{'name_' . app()->getLocale()})
@else
    @section('title', 'Auctions')
@endif
@section('breadcrumb')
    @if(isset($category))
        {{ Breadcrumbs::render('auctions', $category->slug, $category->{'name_' . app()->getLocale()}) }}
    @else
        {{ Breadcrumbs::render('auctions') }}
    @endif
@endsection
@section('content')
    @if(isset($featuredAuctions))
    <section class="featured-auction-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="section-header cl-white mw-100 left-style">
                <h3 class="title">Bid on These Featured Auctions!</h3>
            </div>
            <div class="row justify-content-center mb-30-none">
                @foreach($featuredAuctions as $auction)
                <div class="col-sm-10 col-md-6 col-lg-4">
                    @include('frontend.components.auction')
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--============= Featured Auction Section Ends Here =============-->
    @endif

    <!--============= Product Auction Section Starts Here =============-->
    <div class="product-auction padding-bottom" style="margin-top:-25%;">
        <div class="container">
            <div class="row mb--50">
                <div class="col-lg-4 mb-50">
                    <div class="widget">
                        <h5 class="title">Categories</h5>
                        <div class="widget-body">
                            @foreach($categories as $key => $category)
                            <div class="widget-form-group">
                         {{--        <input type="checkbox" value="{{ $category->id }}" name="category" id="check{{ $key }}">
                                <label for="check{{ $key }}">{{ $category->{'name_'.app()->getLocale()} }}</label> --}}
                                <a href="{{ route('auctionsByCategory', ['category' => $category->slug]) }}"> {{ $category->{'name_'.app()->getLocale()} }} </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
         {{--           <div class="widget">
                        <h5 class="title">Country</h5>
                        <div class="widget-body">
                            <div class="widget-form-group">
                                <input type="checkbox" name="check-by-type" id="check1">
                                <label for="check1">Live Auction</label>
                            </div>
                            <div class="widget-form-group">
                                <input type="checkbox" name="check-by-type" id="check2">
                                <label for="check2">Timed Auction</label>
                            </div>
                            <div class="widget-form-group">
                                <input type="checkbox" name="check-by-type" id="check3">
                                <label for="check3">Buy Now</label>
                            </div>
                        </div>
                    </div>  --}}
                    <div class="widget">
                        <h5 class="title">Ending Within</h5>
                        <div class="widget-body">
                            <div class="widget-form-group">
                                <input type="checkbox" name="check-by-type" id="day">
                                <label for="day">1 Day</label>
                            </div>
                            <div class="widget-form-group">
                                <input type="checkbox" name="check-by-type" id="week">
                                <label for="week">1 Week</label>
                            </div>
                            <div class="widget-form-group">
                                <input type="checkbox" name="check-by-type" id="month1">
                                <label for="month1">1 Month</label>
                            </div>
                            <div class="widget-form-group">
                                <input type="checkbox" name="check-by-type" id="month3">
                                <label for="month3">3 Month</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mb-50">
                    <div class="product-header mb-40 style-2">
                        <div class="product-header-item">
                            <div class="item">Sort By : </div>
                            <select name="sort-by" class="select-bar">
                                <option value="all">All</option>
                                <option value="name">Name</option>
                                <option value="date">Date</option>
                                <option value="type">Type</option>
                                <option value="car">Car</option>
                            </select>
                        </div>
                        <div class="product-header-item">
                            <div class="item">Show : </div>
                            <select name="sort-by" class="select-bar">
                                <option value="09">06</option>
                                <option value="21">09</option>
                                <option value="30">30</option>
                                <option value="39">39</option>
                                <option value="60">60</option>
                            </select>
                        </div>
                        <form class="product-search ml-auto">
                            <input type="text" placeholder="Item Name">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    @if($products)
                    <div class="row mb-30-none justify-content-center">
                        @foreach($products as $product)
                        <div class="col-sm-10 col-md-6">
                            @include('frontend.components.auction')
                        </div>
                        @endforeach
                    </div>

                    {{ $products->links('frontend.components.auctions-pagination') }}
                    @else
                        <h5>{{ __('No products found') }}</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--============= Product Auction Section Ends Here =============-->

@endsection
