@extends('frontend.layouts.master')
@section('title', $auction->title)
@section('breadcrumb')
    {{ Breadcrumbs::render('auction', $auction->slug, $auction->title) }}
@endsection
@section('styles')
    @livewireStyles
@endsection
@section('content')

    <!--============= Product Details Section Starts Here =============-->
    <section class="product-details padding-bottom mt--240 mt-lg--440">
        <div class="container-fluid">
            <div class="col-md-8 offset-md-2">
                <div class="product-details-slider-top-wrapper">
                    <div class="product-details-slider owl-theme owl-carousel" id="sync1">
                        <div class="slide-top-item">
                            <div class="slide-inner">
                                <img src="{{ $auction->thumbnail }}" style="max-height: 600px" alt="product">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 offset-md-2">
                <div class="row mt-40-60-80">
                <div class="col-lg-12">
                    <div class="product-details-content">
                        <div class="product-details-header">
                            <h2 class="title">{{ $auction->title }}</h2>
                            <ul>
                                <li>Auction #: {{ $auction->id }}</li>
                            </ul>
                        </div>

                        <div class="item">
                            <table class="table table-sm" x-data="auction">
                                <thead>
                                    <th>Title</th>
                                    <th>Made In</th>
                                    <th>Image</th>
                                    <th>Unit</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th class="text-center">{{ __('Bid') }}</th>
                                </thead>
                                <tbody>
                                @foreach($auction->products as $key => $product)
                                    <tr>
                                        <td style="width: 40%">{{ optional($product->catalogue)->title }}</td>
                                        <td style="width: 10%">{{ $product->made_in }}</td>
                                        <td style="width: 10%">
                                            <img style="width: 60px" src="{{ count(optional($product->catalogue)->images) ? optional($product->catalogue)->images[0]->src : asset('frontend/images/50.webp') }}"
                                                 alt="{{ optional($product->catalogue)->title }}">
                                        </td>
                                        <td style="width: 10%">{{ optional($product->unit)->title }}</td>
                                        <td style="width: 10%">{{ $product->quantity }}</td>
                                        <td style="width: 10%">${{ round($product->price,2) }}</td>
                                        <td style="width: 10%" class="text-center">
                                            <a href="{{ route('auction-product', [
                                                            'slug' => $auction->slug,
                                                            'catalogue_slug' => $product->catalogue->slug,
                                                            'id' => $product->id,
                                                            ]) }}"
                                               class="custom-button">
                                                    {{ __('Bid Now') }}
                                            </a>
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
        <div class="product-tab-menu-area mb-40-60 mt-70-100">
            <div class="container">
                <ul class="product-tab-menu nav nav-tabs">
                    <li>
                        <a href="#details" class="active" data-toggle="tab">
                            <div class="thumb">
                                <img src="{{ asset('frontend/images/product/tab1.png') }}" alt="product">
                            </div>
                            <div class="content">Description</div>
                        </a>
                    </li>
                    <li>
                        <a href="#questions" data-toggle="tab">
                            <div class="thumb">
                                <img src="{{ asset('frontend/images/product/tab4.png') }}" alt="product">
                            </div>
                            <div class="content">Questions </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="details">
                    <div class="tab-details-content">
                        <div class="header-area">
                            {!! $auction->description !!}
                        </div>
                    </div>
                </div>
                @include('frontend.partials.auction-details-delivery')
                @include('frontend.partials.auction-details-bid-history')
                @include('frontend.partials.auction-details-faq')
                </div>
            </div>
    </section>
    <!--============= Product Details Section Ends Here =============-->
@endsection
@section('scripts')
@endsection
