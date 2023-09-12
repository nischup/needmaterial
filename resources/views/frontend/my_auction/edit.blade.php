@extends('frontend.layouts.master')
@section('title', 'Edit Auction')
@section('breadcrumb')
    {{ Breadcrumbs::render('frontend.edit-auction', $auction->id) }}
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
                            <h4 class="title">Edit Auction</h4>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane show active fade" id="current">
                                @livewire('auction.edit-my-auction', ['auction_id' => $auction->id])
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
