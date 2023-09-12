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
                            <h4 class="title">My Bids</h4>
                        </div>
                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    <table class="table table-sm">
                                        <thead>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Brand.Type</th>
                                            <th>Submission Date</th>
                                            <th> Status</th>
                                        </thead>
                                        <tbody>
                                            @foreach($auctionProduct as $my_bid)
                                                <tr>
                                                    <td data-purchase="item">{{ $my_bid->id }}</td>
                                                    <td data-purchase="item">

                                                    <a href="{{ route('auction-product-details', ['id' => $my_bid->product['id']]) }}">{{ $my_bid->product->catalogue->slug .'-'.$my_bid->product['id']  }}</a>

                                                    </td> 
                                                    <td data-purchase="item">
                                                            {{ $my_bid->price }}
                                                    </td>  
                                                    <td data-purchase="item">
                                                            {{ $my_bid->quantity }}
                                                    </td> 
                                                    <td style="width: 10%">{{ $my_bid->exact_item_require == 0 ? "Any Brand" : "Exact Brand" }}</td>
                                                    <!--<td data-purchase="item">-->
                                                    <!--    @if ($my_bid->unit != '')-->
                                                    <!--        {{ $my_bid->unit->title }}-->
                                                    <!--    @endif-->
                                                    <!--</td>-->
                                                    {{-- <td data-purchase="item"><img src="{{ $my_bid->auction->thumbnail }}" width="50px" alt="no image"></td> --}}
                                                    <td data-purchase="highest bid">{{ date("j F, g:i a", strtotime($my_bid->created_at)) }}</td>
                                                    <td>
                                                        <a href="{{ route('auction-product-details',$my_bid->id) }}"></a>
                                                    </td>

                                                    <td>
                                                        @if ($my_bid->product['status'] == 0)
                                                            <span style="color: blue;"> Running </span>
                                                            @elseif ($my_bid->product['status'] == 1 && $my_bid->winner_status == 1)
                                                                <span style="color: green;"> Won </span>
                                                            @elseif ($my_bid->product['status'] != 0 && $my_bid->winner_status != 1)
                                                                <span style="color: green;"> Close </span>  
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