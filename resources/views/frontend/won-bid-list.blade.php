@extends('frontend.layouts.master')
@section('title', 'My Bids')
@section('breadcrumb')
    {{ Breadcrumbs::render('dashboard') }}
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
                            <h4 class="title">Won Bids</h4>
                        </div>
                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    <table class="purchasing-table">
                                        <thead>
                                            <th>Item</th>
                                            <th>Auc.Type</th>
                                            <th>Price</th>
                                            {{-- <th>Lowest Bid</th> --}}
                                            <th>Req Quantity</th>
                                            <th>Bidding Quantity</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>

                                            @foreach($won_products as $product)
                                                <tr style="font-size:12px;">
                                                    <td data-purchase="item" style="font-size:12px;">   
                                                        <a href="{{ route('auction-product-details', ['id' => $product->id,]) }}">{{ $product->catalogue->slug.'-'.$product->id  }}</a> 
                                                    </td>
                                                    <td style="font-size:12px;">
                                                        @if ($product->auction['service_type'] == 1)
                                                             BUYING
                                                            @elseif ($product->auction['service_type'] == 2)
                                                                SELLING
                                                            @elseif ($product->auction['service_type'] == 3)
                                                                QUOTATION
                                                        @endif
                                                    </td>
                                                    <td style="font-size:12px;" data-purchase="item">{{ $product->bids[0]['price'] }}</td>
                                          {{--           <td  style="font-size:12px;"data-purchase="item">{{ $product->lowest_bid ? $product->lowest_bid : '0' }}</td> --}}
                                                    <td  style="font-size:12px;"data-purchase="item">{{ $product['quantity'] }}</td>
                                                    <td  style="font-size:12px;"data-purchase="item">{{ $product->bids[0]['bid_qty'] }}</td>
                                                    <td  style="font-size:12px;"data-purchase="expires"> 

                                                        @if ($product->status == 0)
                                                            <span style="color: blue;"> Running </span>
                                                            @elseif ($product->status == 1)
                                                                <span style="color: green;"> Won </span>  
                                                            @elseif ($product->status == 2)
                                                                <span style="color: green;"> In-Progress </span>
                                                            @elseif ($product->status == 3)
                                                                <span style="color: green;"> Shipped </span> 
                                                       {{--      @elseif ($product->status == 4)
                                                                <span style="color: blue;"> Delivery </span>   --}}   
                                                            @elseif ($product->status == 5 && $product->auction['service_type'] == 1)
                                                                <span style="color: green;font-weight: bold;"> Delivered </span>   
                                                            @elseif ($product->status == 5 && $product->auction['service_type'] == 2)
                                                                <span style="color: green;font-weight: bold;"> Received </span>
                                                        @endif
                                                     </td>
                                                     <td style="font-size:12px;">
                                                        @if($product->status == 1 && $product->auction['service_type'] == 1 && $product->winner_id != NULL)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="2">
                                                                <button type="submit" class="custom-button btn-xs">In-Progress</button>
                                                            </form>  

                                                            @elseif($product->status == 2 && $product->auction['service_type'] == 1 && $product->winner_id != NULL)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="3">
                                                                <button type="submit" class="custom-button btn-xs">Shipped</button>
                                                            </form>  

                                                            @elseif($product->status == 3 && $product->auction['service_type'] == 2 && $product->winner_id != NULL)
                                                            <form action="{{ route('set-auction-bid-status-update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="auction_product_id" value="{{ $product->id }}">
                                                                 <input type="hidden" name="status" value="5">
                                                                <button type="submit" class="custom-button btn-xs">Received</button>
                                                            </form>

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
    <!--============= Dashboard Section Ends Here =============-->
@endsection