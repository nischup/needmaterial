@extends('frontend.layouts.master')
@section('title', 'Dashboard')
@section('breadcrumb')
    {{ Breadcrumbs::render('dashboard') }}
@endsection
@section('content')
    <!--============= Dashboard Section Starts Here =============-->
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row justify-content-center">
                @include('frontend.layouts.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-widget mb-40">
                        <div class="dashboard-title mb-30">
                            <h5 class="title">My Activity (<small style="color:green;"> Login as a {{ auth()->user()->user_type == 1 ? "Customer" : "Supplier" }} </small>) <a style="margin-left: 25%; color: #fff;" href="{{ route('frontend.newAuction') }}" class="btn custom-button"> Create New Auction </a> </h5>
                        </div>
                        <div class="row justify-content-center mb-30-none">
                            <div class="col-md-4 col-sm-6">
                                <div class="dashboard-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/dashboard/01.png') }}" alt="dashboard">
                                    </div>
                                    <div class="content">
                                        <h2 class="title"><span class="counter">{{ $active_products_count }}</span></h2>
                                        <h6 class="info">Active Bids</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="dashboard-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/dashboard/02.png') }}" alt="dashboard">
                                    </div>
                                    <div class="content">
                                        <h2 class="title"> <a href="{{ route('frontend.wonBids-list') }}"><span class="counter">{{ $won_products_count }}</span></a> </h2>
                                        <h6 class="info">Items Won</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="dashboard-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/dashboard/03.png') }}" alt="dashboard">
                                    </div>
                                    <div class="content">
                                        <h2 class="title"><a href="{{ route('frontend.dashboard.favorites') }}"><span class="counter">{{ $favourote_count }}</span></a></h2>
                                        <h6 class="info">Favorites</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-widget">
                        <h5 class="title mb-10">Bid Summary</h5>
                        <div class="dashboard-purchasing-tabs">
                            <ul class="nav-tabs nav">
                                <li>
                                    <a href="#current" class="active" data-toggle="tab">Active Bids</a>
                                </li>
                                <li>
                                    <a href="#pending" data-toggle="tab">Notification Bids</a>
                                </li>
                                <li>
                                    <a href="#history" data-toggle="tab">Won Bids</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    <table class="purchasing-table">
                                        <thead>
                                            <th>Item</th>
                                            <th>Highest Bid</th>
                                            <th>Lowest Bid</th>
                                            <th>Expires</th>
                                        </thead>
                                        <tbody>
                                            @foreach($active_products as $product)
                                                <tr>
                                                    <td data-purchase="item">   
                                                        <a href="{{ route('auction-product-details', ['id' => $product->id,]) }}">{{ $product->catalogue->slug.'-'.$product->id  }}</a> 
                                                    </td>
                                                    <td data-purchase="highest bid"> {{ $product->highest_bid ? $product->highest_bid : '0' }}</td>
                                                    <td data-purchase="lowest bid"> {{ $product->lowest_bid ? $product->lowest_bid : '0' }}</td>
                                                    <td data-purchase="expires">{{ $product->auction->end_time }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane show fade" id="pending">
                                    <table class="purchasing-table">
                                        <thead>
                                            <th>Item</th>
                                            <th>Highest Bid</th>
                                            <th>Lowest Bid</th>
                                            <th>Expires</th>
                                        </thead>
                                        <tbody>
                                            @foreach($notification_products as $product)
                                                <tr>
                                                    <td data-purchase="item">   
                                                        <a href="{{ route('auction-product-details', ['id' => $product->id,]) }}">{{ $product->catalogue->slug.'-'.$product->id  }}</a> 
                                                    </td>
                                                    <td data-purchase="highest bid"> {{ $product->highest_bid ? $product->highest_bid : '0' }}</td>
                                                    <td data-purchase="lowest bid"> {{ $product->lowest_bid ? $product->lowest_bid : '0' }}</td>
                                                    <td data-purchase="expires">{{ $product->auction->end_time }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane show fade" id="history">
                                    <table class="purchasing-table">
                                        <thead>
                                            <th>Item</th>
                                            <th>Bid Price</th>
                                            <th>Lowest Bid</th>
                                            <th>Req Quantity</th>
                                            <th>Bidding Quantity</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>

                                            @foreach($won_products as $product)
                                                <tr>
                                                    <td data-purchase="item">   
                                                        <a href="{{ route('auction-product-details', ['id' => $product->id,]) }}">{{ $product->catalogue->slug.'-'.$product->id  }}</a> 
                                                    </td>
                                                    <td data-purchase="item">{{ $product->bids[0]['price'] }}</td>
                                                    <td data-purchase="item">{{ $product->lowest_bid ? $product->lowest_bid : '0' }}</td>
                                                    <td data-purchase="item">{{ $product['quantity'] }}</td>
                                                    <td data-purchase="item">{{ $product->bids[0]['bid_qty'] }}</td>

                                                    <td data-purchase="expires"> 

                                                        @if ($product->status == 0)
                                                            <span style="color: blue;"> Running </span>
                                                            @elseif ($product->status == 1)
                                                                <span style="color: green;"> Won </span>  
                                                            @elseif ($product->status == 2)
                                                                <span style="color: green;"> In-Progress </span>
                                                            @elseif ($product->status == 3)
                                                                <span style="color: green;"> Shipped </span> 
                                                        {{--     @elseif ($product->status == 4)
                                                                <span style="color: blue;"> Delivery </span> --}}     
                                                            @elseif ($product->status == 5)
                                                                <span style="color: green;font-weight: bold;"> Delivered </span>
                                                        @endif
                                                     </td>

                                                     <td>
                                                        @if($product->status == 1 && $product->winner_id != NULL)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="2">
                                                                <button type="submit" class="custom-button btn-xs">In-Progress</button>
                                                            </form>  

                                                            @elseif($product->status == 2 && $product->winner_id != NULL)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="3">
                                                                <button type="submit" class="custom-button btn-xs">Shipped</button>
                                                            </form>  

                                                    {{--         @elseif($product->status == 3 && $product->winner_id != NULL)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="4">
                                                                <button type="submit" class="custom-button btn-xs">Delivery</button>
                                                            </form> --}}

                                                         @endif
                                                     </td>

                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= Dashboard Section Ends Here =============-->
@endsection
