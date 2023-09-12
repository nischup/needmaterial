@extends('frontend.layouts.master')
@section('title', $bid->title)
@section('breadcrumb')
    {{ Breadcrumbs::render('my-auctions-product-bid',
                     $bid->product->auction->slug,
                      $bid->product->id,
                       $bid->product->auction->title,
                        $bid->product->catalogue->title,
                        $bid->id) }}
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
                            <h4 class="title">{{ __('Bid Detail') }}</h4>
                        </div>
                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    {{ $bid->title }}
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= Dashboard Section Ends Here =============-->
@endsection
