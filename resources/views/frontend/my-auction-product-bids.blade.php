@extends('frontend.layouts.master')
@section('title', $product->catalogue->title)
@section('breadcrumb')
    {{ Breadcrumbs::render('my-auctions-product-bids', $product->auction->slug, $product->id, $product->auction->title, $product->catalogue->title) }}
@endsection
@section('content')
    <!--============= Dashboard Section Starts Here =============-->
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="row justify-content-center">

                @include('frontend.layouts.sidebar')

                <div class="col-lg-8">
                    <div class="dash-bid-item dashboard-widget mb-40-60">
                        <div class="header">
                            <div class="row">
                                <h4 class="title">{{ __('Auction product bidder list') }}</h4>
                            </div>
                        </div>
                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    @if (session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    @if (session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <table class="table table-sm">
                                        <thead>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Auc.Type</th>
                                        <th>Bidder</th>
                                        <th>Made In</th>
                                        <th>Image</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        {{-- <th>{{ __('Details') }}</th> --}}
                                        @if(!$product->winner_id)
                                        <th>{{ __('Winner') }}</th>
                                        @endif
                                        </thead>
                                        <tbody>
                                            @foreach($product->bids as $bid)
                                                <tr>
                                                <td style="width: 10%">{{ $bid->bidder->id }}</td>
                                                <td style="width: 10%">{{ $product->product_title }}</td>
                                                <td>
                                                        @if ($product->auction['service_type'] == 1)
                                                             BUYING
                                                            @elseif ($product->auction['service_type'] == 2)
                                                                SELLING
                                                            @elseif ($product->auction['service_type'] == 3)
                                                                QUOTATION
                                                        @endif
                                                </td>
                                                <td style="width: 40%">
                                                    @if($bid->bidder->id == $product->winner_id && $bid->winner_status == 1)
                                                        <span class="badge badge-info">{{ $bid->bidder->name }} ({{ __('Winner') }})</span>
                                                    @else
                                                        {{ $bid->bidder->name }}
                                                    @endif
                                                </td>
                                                <td style="width: 20%">{{ $bid->madein->name }}</td>
                                                <td style="width: 10%">
                                                    <img style="width: 60px" src="{{ $bid->images && count($bid->images) ? $bid->images[0]->src : asset('frontend/images/50.webp') }}"
                                                         alt="{{ $bid->title }}">
                                                </td>
                                                <td style="width: 10%">{{ $bid->quantity }}</td>
                                                <td style="width: 10%">{{ round($bid->price,2) }}</td>
                                               {{--  <td style="width: 10%">
                                                    <a href="{{ route('my-auction-product-bid', [
                                                       'slug' => $product->auction->slug,
                                                        'id' => $product->id,
                                                        'bid_id' => $bid->id
                                                    ]) }}">
                                                       <i class="fa fa-eye"></i>
                                                    </a>
                                                </td> --}}
                                                <td>
                                                    @if ($product->status == 0)
                                                        <span style="color: blue;"> Running </span>
                                                    @elseif ($product->status == 1 && $bid->winner_status == 1)
                                                        <span style="color: green; font-weight: bold;"> Won </span>  
                                                    @elseif ($product->status == 1 && $bid->winner_status != 1)
                                                        <span style="color: red;"> Not Won </span>  
                                                    @elseif ($product->status == 2 && $bid->winner_status == 1)
                                                        <span style="color: green;"> In-Progress </span>
                                                    @elseif ($product->status == 3 && $bid->winner_status == 1)
                                                        <span style="color: green;"> Shipped </span> 
                                              {{--       @elseif ($product->status == 4)
                                                        <span style="color: green;"> Delivered </span>  --}}    
                                                    @elseif ($product->status == 5 && $bid->winner_status == 1 && $product->auction['service_type'] == 1)
                                                        <span style="color: green;"> Received </span>  
                                                    @elseif ($product->status == 5 && $bid->winner_status == 1 && $product->auction['service_type'] == 2)
                                                        <span style="color: green;"> Delivered </span>
                                                        @else
                                                         <span style="color: red;"> Not a Winner </span>
                                                    @endif

                                          
                                                @if($product->status == 3 && $product->winner_id != NULL && $bid->winner_status == 1 && $product->auction['service_type'] == 1)
                                                    <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                                                        <input type="hidden" name="auction_product_id" value="{{ $bid->auction_product_id }}">
                                                         <input type="hidden" name="status" value="5">
                                                        <input type="hidden" name="bidder_id" value="{{ $bid->bidder->id }}">
                                                   
                                                        <button type="submit" class="custom-button btn-xs">Received</button>
                                                    </form>
                                                 @endif

                                                </td>
                                                <td>
                                                    @if(!$product->winner_id)
                                                    <form action="{{ route('set-auction-bid-winner') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="auction_product_id" value="{{ $bid->auction_product_id }}">     
                                                        <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                                                        <input type="hidden" name="bidder_id" value="{{ $bid->bidder->id }}">
                                                        <input type="hidden" name="bid_price" value="{{ round($bid->price,2) }}">
                                                        <button type="submit" class="custom-button btn-xs">Make Winner</button>
                                                    </form>
                                                    @endif
                                                </td>
                                                <td>
                                                @if($product->status == 1 && $product->auction['service_type'] == 2 && $product->winner_id != NULL)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="2">
                                                                <button type="submit" class="custom-button btn-xs">In-Progress</button>
                                                            </form>  

                                                            @elseif($product->status == 2 && $product->winner_id != NULL && $product->auction['service_type'] == 2)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="3">
                                                                <button type="submit" class="custom-button btn-xs">Shipped</button>
                                                            </form>  
{{-- 
                                                            @elseif($product->status == 3 && $product->auction['service_type'] == 2 && $product->winner_id != NULL)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="5">
                                                                <button type="submit" class="custom-button btn-xs">Received</button>
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
    </section>
@endsection
