@extends('frontend.layouts.master')
@section('title', 'My Auctions')
@section('breadcrumb')
    {{ Breadcrumbs::render('my-auctions', $status) }}
@endsection
@section('styles')
    @livewireStyles
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
                            <h4 class="title">Closed Auctions List</h4>
                        </div>
                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    <table class="table table-sm">
                                        <thead>
                                            <th>#</th>
                                            <th>Auction Title</th>
                                            <th>Auction Type</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th colspan="2">Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach($auctions as $auction)
                                                <tr>
                                                    <td data-purchase="item">{{ $auction->id }}</td>
                                                    <td data-purchase="item">
                                                     {{--    <a target="_blank" href="{{ route('auction', ['slug' => $auction->slug]) }}">
                                                            {{ $auction->title }}
                                                        </a> --}}
                                                        {{ $auction->title }}
                                                    </td>
                                                    <td>
                                                        @if ($auction->service_type == 1)
                                                             BUYING
                                                            @elseif ($auction->service_type == 2)
                                                                SELLING
                                                            @elseif ($auction->service_type == 3)
                                                                QUOTATION
                                                        @endif
                                                    </td>
                                                    <td data-purchase="highest bid">{{ date("j F, g:i a", strtotime($auction->start_time)) }}</td>
                                                    <td data-purchase="lowest bid">{{ date("j F, g:i a", strtotime($auction->end_time)) }}</td>
                                                    <td><a href="{{ route('frontend.edit-auction', ['id' => $auction->id]) }}"> Edit </a></td>
                                                    <td data-purchase="expires"><a href="{{ route('my-auction-won-products', ['slug' => $auction->slug]) }}"> View Details</a></td>
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
@section('scripts')
    @livewireScripts
@endsection
