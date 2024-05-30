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
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Brand.Type</th>
                                            <th>Submission Date</th>
                                            <th> Status</th>
                                        </thead>
                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach($auctionProduct as $my_bid)
                                                <tr>
                                                    {{-- <td data-purchase="item">{{ $my_bid->id }}</td> --}}
                                                    <td data-purchase="item">{{ $i++; }}</td>
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

                                                                <span style="color: green;"> Won </span> <br>

                                                               @if ($my_bid->winner_status == 1 && auth()->check() && $my_bid->user_id == auth()->user()->id)
                                                                <div class="row">
                                                                    @if (is_null($my_bid->confirmation_status))
                                                                        <div class="col-md-6">
                                                                            <form action="{{ route('set-winner-accept-bid-status-update') }}" method="post">
                                                                                @csrf
                                                                                <input type="hidden" name="auction_product_id" value="{{ $my_bid->id }}">
                                                                                <input type="hidden" name="status" value="200">
                                                                                <button type="submit" class="custom-button btn-xs"> Accept </button>
                                                                            </form> 
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <form action="{{ route('set-winner-reject-bid-status-update') }}" method="post">
                                                                                @csrf
                                                                                <input type="hidden" name="auction_product_id" value="{{ $my_bid->id }}">
                                                                                <input type="hidden" name="status" value="400">
                                                                                <button type="submit" class="custom-button btn-xs"> Reject </button>
                                                                            </form>  
                                                                        </div>
                                                                    @elseif ($my_bid->confirmation_status == 200)
                                                                        <div class="col-md-12">
                                                                            <p class="text-success">Accepted by me</p>
                                                                        </div>
                                                                    @elseif ($my_bid->confirmation_status == 400)
                                                                        <div class="col-md-12">
                                                                            <p class="text-danger">Rejected by me</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
  
                                                        

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