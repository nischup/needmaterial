@extends('frontend.layouts.master')
@section('title', $auction->title)
@section('breadcrumb')
    {{ Breadcrumbs::render('my-auctions-products', $auction->slug, $auction->title) }}
@endsection
@section('content')
    <!--============= Dashboard Section Starts Here =============-->
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="row justify-content-center">

                @include('frontend.layouts.sidebar')

                <div class="col-lg-8">
                    <div class="dash-bid-item dashboard-widget mb-40-60">

                    <div class="tab-pane fade show" id="delevery">
                            <div class="shipping-wrapper">
                                <div class="item">
                                    <h5 class="title">Auction Details</h5>
                                    <div class="table-wrapper">
                                        <table class="shipping-table">
                                            <thead>
                                           {{--      <tr>
                                                    <th>Available delivery methods </th>
                                                    <th>Price</th>
                                                </tr> --}}
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Service Type</td>
                                                    <td>
                                                        @if ($auction->service_type == 1)
                                                        BUYING 
                                                        @elseif ($auction->service_type == 2)
                                                        SELLING     
                                                        @elseif ($auction->service_type == 3)
                                                        QUOTATION
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bid Type</td>
                                                    <td>  
                                                        @if ($auction->is_open_bid == 1)
                                                        Open Bid 
                                                        @elseif ($auction->is_open_bid == 0)
                                                        Close Bid
                                                        @endif 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Delivery Address</td>
                                                    <td>{{ $auction->delivery_address }}</td>
                                                </tr>  

                                                <tr>
                                                    <td>With Delivery Charge</td>
                                                    <td> {{ $auction->included_delivery_cost == 1 ? "YES" : "NO"}} </td>
                                                </tr>

                                                <tr>
                                                    <td>With VAT</td>
                                                    <td> {{ $auction->vat == 1 ? "YES" : "NO" }}  </td>

                                                </tr>

                                                <tr>
                                                    <td>Description</td>
                                                    <td>{!! $auction->description !!}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="header">
                            <h4 class="title">Auction Win Products List</h4>
                        </div>

                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    <table class="table table-sm">
                                        <thead>
                                            <th>Product Title</th>
                                            <th>Image</th>
                                            <th>B.Type</th>
                                            <th>Brand</th>
                                            <th>Unit</th>
                                            <th> Qty</th>
                                            <th style="width: 20%">{{ __('Action') }}</th>
                                        </thead>
                                        <tbody>
                                            @foreach($auction->products as $product)

                                            @if ($product->winner_id != null)
                                                <tr>
                                                <td style="width: 40%">
                                          
                                                      {{ $product->product_title }}
                                                  
                                                </td>
                                                <td style="width: 10%">
                                                    <img style="width: 60px" src="{{ count(optional($product->catalogue)->images) ? optional($product->catalogue)->images[0]->src : asset('frontend/images/50.webp') }}"
                                                         alt="{{ optional($product->catalogue)->title }}">
                                                </td>
                                                <td style="width: 10%">{{ $product->exact_item_require == 0 ? "Any Brand" : "Exact Brand" }}</td>
                                                <td style="width: 10%">{{ optional($product->brand)->title }}</td>
                                                <td style="width: 10%">{{ optional($product->unit)->title }}</td>
                                                <td style="width: 10%">{{ $product->quantity }}</td>
                                                <td style="width: 20%">
                                                    <a href="{{ route('my-auction-product-bids-winner', [
                                                            'slug' => $auction->slug,
                                                            'id' => $product->id,
                                                            ]) }}"
                                                       class="">
                                                        {{ __('Show Winner') }}
                                                    </a>
                                                </td>
                                                </tr>
                                                @endif
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
