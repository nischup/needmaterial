@extends('frontend.layouts.master')
@section('title', 'Auction bid success')
@section('breadcrumb')
    {{ Breadcrumbs::render('auction', $auction->slug, $auction->title) }}
@endsection
@section('styles')
    @livewireStyles
@endsection
@section('content')
    <section class="about-section">
        <div class="container pb-50">
            <div class="about-wrapper mt--100 mt-lg--440 pb-50 padding-top">
                <div class="row">
                    <div class="col-lg-7 col-xl-6">
                        <div class="about-content">
                            <h4 class="subtitle">Bid Success</h4>
                            <p>We will get back to you when auction ended and result being ready</p>
                            <div style="text-align: center" class="pt-5">
                                <div class="item">
                                    <a href="{{ route('auction-product', ['slug' => $slug, 'catalogue_slug' => $catalogueSlug, 'id' => $id])}}" class="custom-button">Go back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-thumb">
                    <img src="{{ asset('frontend/images/about/about.png') }}" alt="about">
                </div>
            </div>
        </div>
    </section>
    <!--============= About Section Ends Here =============-->
@endsection
