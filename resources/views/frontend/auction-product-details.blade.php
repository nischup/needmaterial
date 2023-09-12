@extends('frontend.layouts.master')
@section('title', $product->auction->title)
@section('breadcrumb')
    {{ Breadcrumbs::render('auction-product', $product->auction->slug, $product->auction->title, $product->catalogue->slug, $product->id, $product->catalogue->title) }}
@endsection
@section('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection
@section('content')

    <!--============= Product Details Section Starts Here =============-->
    <section class="product-details padding-bottom mt--240 mt-lg--440">
        <div class="container">
            @if(count($images))
            <div class="product-details-slider-top-wrapper">
                <div class="product-details-slider owl-theme owl-carousel" id="sync1">
                    @foreach($images as $image)
                    <div class="slide-top-item">
                        <div class="slide-inner">
                            <img src="{{ $image->src }}" style="max-height: 600px" alt="no product">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="product-details-slider-wrapper">
                @if(isset($images[1]))
                    <div class="product-bottom-slider owl-theme owl-carousel" id="sync2">
                        @foreach($images as $image)
                        <div class="slide-bottom-item">
                            <div class="slide-inner">
                                <img src="{{ $image->src }}" alt="no product found">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <span class="det-prev det-nav">
                        <i class="fas fa-angle-left"></i>
                    </span>
                    <span class="det-next det-nav active">
                        <i class="fas fa-angle-right"></i>
                    </span>
                @endif
            </div>
            @endif
            <div class="product-details-slider-wrapper">
                <div class="row mt-40-60-80">
                <div class="col-lg-8">
                    <div class="product-details-content">
                        <div class="price-table mb-30">
                            {{-- <h3 class="title">Title: <small>{{ $product->product_title }}</small> </h3> --}}
                            <h3 class="title">Title: <small>{{ $product->catalogue->slug.'-'.$product->id  }}</small> </h3>
                           {{--  <ul>
                                <li>Item #: {{ $product->id }}</li>
                            </ul> --}}
                        </div>
                        <ul class="price-table mb-30" style="padding-bottom: 10px">
                            <li>
                                <h6 class="info">Product Title: </h6><span>{{ $product->catalogue->title }}</span>
                            </li>
                            <li>
                                <h6 class="info">Made In:</h6>
                                <span class="details">{{ $product->made_by ? $product->made_by->name : __('Unknown') }}</span>
                            </li>
                            <li>
                                <h6 class="info">Unit:</h6>
                                <span class="details">{{ $product->unit->title }}</span>
                            </li>
                            <li>
                                <h6 class="info">Brand Type:</h6>
                                <span class="details">{{ $product->exact_item_require == 0 ? "Any Brand" : "Exact Brand" }}</span>
                            </li>
                            <li>
                                <h6 class="info">Required Quantity:</h6>
                                <span class="details">{{ $product->quantity }}</span>
                            </li>
                            <li>
                                <h6 class="info">Delivery Charge:</h6>
                                <span class="details">{{ $product->auction->included_delivery_cost == 1 ? "YES" : "NO"}}</span>
                            </li>
                            <li>
                                <h6 class="info">VAT:</h6>
                                <span class="details">{{ $product->auction->vat == 1 ? "YES" : "NO" }} </span>
                            </li>
                            <li>
                                <h6 class="info">Auction Type:</h6>
                                <span class="details">
                                    @if ($product->auction->service_type == 1)
                                        <strong style="color:green;"> BUYING </strong>
                                    @elseif($product->auction->service_type == 2)
                                        <strong style="color:green;"> SELLING </strong>
                                    @elseif($product->auction->service_type == 3)
                                        <strong style="color:green;"> QUOTATION </strong>
                                    @endif
                                </span>
                            </li>
                            <br>
                          {{--   <li>
                                <h6 class="info">Direct Contact:</h6>
                                <a style="font-size: 50px;" href="https://api.whatsapp.com/send?phone=01686844781" class="mr-3"><i class="fab fa-whatsapp whatsapp"></i> <span style="font-size: 18px;">Click Here</span> </a>
                            </li> --}}
                        </ul>
                        <div class="card" style="background: #ebf2ff" x-data="auction">
                            <div class="card-body">
                                <form @submit.prevent="submit">

                                    <div class="row">
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="price">{{ __('Price') }}</label>
                                                <input type="number" x-model="price" class="form-control form-control-sm" id="price" placeholder="Enter price">
                                                <template x-if="errors.hasOwnProperty('price')">
                                                    <span class="text-danger error"  x-text="errors.price"></span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity">{{ __('Bid Quantity') }}</label>
                                                <input type="number" max="{{ $product->quantity }}" x-model="quantity" disabled class="form-control form-control-sm" id="quantity" placeholder="Quantity">
                                                <template x-if="errors.hasOwnProperty('quantity')">
                                                    <span class="text-danger error"  x-text="errors.quantity"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unit">{{ __('Unit') }}</label>
                                                <select x-model="unit" class="form-control form-control-sm" id="unit">
                                                    {{-- <option value="" selected disabled>Select Unit</option> --}}
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}" selected disabled>{{ $unit->title }}</option>
                                                    @endforeach
                                                </select>
                                                <template x-if="errors.hasOwnProperty('unit')">
                                                    <span class="text-danger error"  x-text="errors.unit"></span>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unit">{{ __('Made in') }}</label>
                                                <select x-model="made_in" class="form-control form-control-sm" id="made_in">
                                                    <option value="" selected disabled>Select Made in</option>
                                                    @foreach($made_in as $made)
                                                        <option value="{{ $made->id }}">{{ $made->name }}</option>
                                                    @endforeach
                                                </select>
                                                <template x-if="errors.hasOwnProperty('made_in')">
                                                    <span class="text-danger error"  x-text="errors.made_in"></span>
                                                </template>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="brand">{{ __('Brand') }}</label>

                                                @if($product->exact_item_require == 0)

                                                <select x-model="brand" class="form-control form-control-sm" id="brand">
                                                    <option value="" selected disabled>Select Brand</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                                    @endforeach
                                                </select>

                                                @elseif($product->exact_item_require == 1)

                                                <select x-model="brand" class="form-control form-control-sm" id="brand">
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}" selected disabled>{{ $brand->title }}</option>
                                                    @endforeach
                                                </select>

                                                @endif

                                                <template x-if="errors.hasOwnProperty('brand')">
                                                    <span class="text-danger error"  x-text="errors.brand"></span>
                                                </template>
                                            </div>
                                        </div>
                                        @if($product->auction->included_delivery_cost == 1)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="delivery_charge">{{ __('Delivery Charge') }}</label>
                                                <input type="number" x-model="delivery_charge" class="form-control form-control-sm" id="delivery_charge" placeholder="Charge">
                                                <template x-if="errors.hasOwnProperty('delivery_charge')">
                                                    <span class="text-danger error"  x-text="errors.delivery_charge"></span>
                                                </template>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="images">{{ __('Images') }}</label>
                                        <input type="file" accept="image/*" multiple id="images">
                                        <template x-if="errors.hasOwnProperty('images')">
                                            <span class="text-danger error"  x-text="errors.images.*"></span>
                                        </template>
                                    </div>
                                    <a href="{{ route('auction', ['slug' => $product->auction->slug]) }}" class="custom-button" style="background: -webkit-linear-gradient(90deg, #3da9f5 0%, #c7b5ff 100%)">Back</a>
                                    <a href="{{ route('frontend.favorites.store', ['id' => $product->auction->id ]) }}" class="rating custom-button active border"><i class="fas fa-star"></i> Add to Wishlist</a>
                                    <div class="row float-right">

                                        {{-- @if(count($product->ownBids)) --}}
                     {{--                        <button type="button" disabled style="background-color: #a5d5ff; cursor: not-allowed">Already submitted</button>  --}}
                                            @if (Auth::user()->id == $product->auction->user_id)
                                                <p  style="color: red; font-weight:bold;"> No Permission to submit bid </p>
                                            @elseif (Auth::user()->user_type == 1 && $product->auction->service_type ==1)
                                                <p  style="color: red; font-weight:bold;"> Customer are not able to submit buying bid </p>
                                            @else
                                                <button type="submit" class="custom-button">Submit this bid</button>
                                        @endif

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="product-sidebar-area">
                        <div class="product-single-sidebar mb-3">
                            <h6 class="title">This Auction Ends in:</h6>
                            <div class="countdown">
                                <div id="bid_counter1"></div>
                            </div>
                            <div class="side-counter-area">
                                <div class="side-counter-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/product/icon1.png') }}" alt="product">
                                    </div>
                                    <div class="content">
                                        <h3 class="count-title"><span class="counter">{{ rand(0,count($product->bids)) }}</span></h3>
                                        <p>Active Bidders</p>
                                    </div>
                                </div>
                                <div class="side-counter-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/product/icon2.png') }}" alt="product">
                                    </div>
                                    <div class="content">
                                        <h3 class="count-title"><span class="counter">{{ rand(0,100) }}</span></h3>
                                        <p>Watching</p>
                                    </div>
                                </div>
                                <div class="side-counter-item">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend/images/product/icon3.png') }}" alt="product">
                                    </div>
                                    <div class="content">
                                        <h3 class="count-title"><span class="counter">{{ count($product->bids) }}</span></h3>
                                        <p>Total Bids</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6 style="margin-left: -40%;"> Delivery Location: </h6>  <br/>
                        <p> <img width="60" height="60" src="{{ asset('frontend/images/google-maps.png') }}"> {{ $product->auction->delivery_address }} </p>

                        </div>

                        <div class="history-table-area" style="margin-top: 20px;" x-data="live" x-init="init()">
                            <h5> Live Bid </h5>
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Bidding Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-if="!live_bids">
                                        <tr><td colspan="2"><i>Loading...</i></td></tr>
                                    </template>
                                    <template x-else x-for="bid in live_bids" :key="bid.id">
                                        <tr>
                                            <td data-history="time" x-text="bid.created_at_diff"></td>
                                            <td data-history="unit price" x-text="bid.price"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
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
                            <div class="content">Auction Description</div>
                        </a>
                    </li>
                    @if($product->auction->included_delivery_cost || $product->auction->vat)
                    <li>
                        <a href="#delevery" data-toggle="tab">
                            <div class="thumb">
                                <img src="{{ asset('frontend/images/product/tab2.png') }}" alt="product">
                            </div>
                            <div class="content">Delivery Options and VAT</div>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="#history" data-toggle="tab">
                            <div class="thumb">
                                <img src="{{ asset('frontend/images/product/tab3.png') }}" alt="product">
                            </div>
                            <div class="content">Bidding History</div>
                        </a>
                    </li>
                    <li>
                        <a href="#questions" data-toggle="tab">
                            <div class="thumb">
                                <img src="{{ asset('frontend/images/product/tab4.png') }}" alt="product">
                            </div>
                            <div class="content">Questions & Answer</div>
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
                            {{ $product->catalogue->description  }}
                        </div>
                    </div>
                </div>
                @if($product->auction->included_delivery_cost || $product->auction->vat)
                <div class="tab-pane fade show" id="delevery">
                    <div class="shipping-wrapper">
                        <div class="item">
                            <h5 class="title">Summary</h5>
                            <div class="table-wrapper">
                                <table class="shipping-table">
                                    <thead>
                                   {{--      <tr>
                                            <th>Available delivery methods </th>
                                            <th>Price</th>
                                        </tr> --}}
                                    </thead>
                                    <tbody>
                         {{--                <tr>
                                            <td>Customer Pick-up (within 10 days)</td>
                                            <td>$0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Standard Shipping (5-7 business days)</td>
                                            <td>Not Applicable</td>
                                        </tr>
                                        <tr>
                                            <td>Expedited Shipping (2-4 business days)</td>
                                            <td>Not Applicable</td>
                                        </tr> --}}

                                        <tr>
                                            <td>With Delivery Charge</td>
                                            <td> {{ $product->auction->included_delivery_cost == 1 ? "YES" : "NO"}} </td>
                                        </tr>

                                        <tr>
                                            <td>With VAT</td>
                                            <td> {{ $product->auction->vat == 1 ? "YES" : "NO" }}  </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="item">
                            <h5 class="title">Notes</h5>
                            <p>Please carefully review our shipping and returns policy before committing to a bid.
                            From time to time, and at its sole discretion, Sbidu may change the prevailing fee structure for shipping and handling.</p>
                        </div>
                    </div>
                </div>
                @endif
                <div class="tab-pane fade show" id="history">
                    <div class="history-wrapper">
                        <div class="item">
                            <h5 class="title">Bid History</h5>
                            <div class="history-table-area">
                                <table class="history-table">
                                    <thead>
                                        <tr>
                                            <th>Bidder</th>
                                            <th>date</th>
                                            <th>time</th>
                                            <th>unit price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product->bids as $bid)
                                        <tr>
                                            <td data-history="bidder">
                                                <div class="user-info">
                                                    <div class="thumb">
                                                        <img src="{{ asset('frontend/images/history/01.png') }}" alt="history">
                                                    </div>
                                                    <div class="content">
                                                        {{ $bid->bidder->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-history="date">{{ $bid->created_at->format('m/d/Y') }}</td>
                                            <td data-history="time">{{ $bid->created_at->format('H:i:s') }}</td>
                                            <td data-history="unit price">{{ $bid->price }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
{{--                                <div class="text-center mb-3 mt-4">--}}
{{--                                    <a href="#0" class="button-3">Load More</a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="questions">
                        <h5 class="faq-head-title">Frequently Asked Questions</h5>
                        <div class="faq-wrapper">
                            <div class="faq-item">
                                <div class="faq-title">
                                    <img src="{{ asset('frontend/assets/css/img/faq.png') }}" alt="css"><span class="title">How to start bidding?</span><span class="right-icon"></span>
                                </div>
                                <div class="faq-content">
                                    <p>All successful bidders can confirm their winning bid by checking the “Sbidu”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-title">
                                    <img src="./assets/css/img/faq.png" alt="css"><span class="title">Security Deposit / Bidding Power </span><span class="right-icon"></span>
                                </div>
                                <div class="faq-content">
                                    <p>All successful bidders can confirm their winning bid by checking the “Sbidu”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-title">
                                    <img src="./assets/css/img/faq.png" alt="css"><span class="title">Delivery time to the destination port </span><span class="right-icon"></span>
                                </div>
                                <div class="faq-content">
                                    <p>All successful bidders can confirm their winning bid by checking the “Sbidu”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-title">
                                    <img src="./assets/css/img/faq.png" alt="css"><span class="title">How to register to bid in an auction?</span><span class="right-icon"></span>
                                </div>
                                <div class="faq-content">
                                    <p>All successful bidders can confirm their winning bid by checking the “Sbidu”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                                </div>
                            </div>
                            <div class="faq-item open active">
                                <div class="faq-title">
                                    <img src="./assets/css/img/faq.png" alt="css"><span class="title">How will I know if my bid was successful?</span><span class="right-icon"></span>
                                </div>
                                <div class="faq-content">
                                    <p>All successful bidders can confirm their winning bid by checking the “Sbidu”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-title">
                                    <img src="./assets/css/img/faq.png" alt="css"><span class="title">What happens if I bid on the wrong lot?</span><span class="right-icon"></span>
                                </div>
                                <div class="faq-content">
                                    <p>All successful bidders can confirm their winning bid by checking the “Sbidu”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>
        </div>
    </section>
    <!--============= Product Details Section Ends Here =============-->
@endsection
@section('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        document.addEventListener('alpine:init', () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            Alpine.data('live', () => ({
                live_bids: false,
                init() {
                    var vm = this;
                    setInterval(() => {
                        $.ajax({
                            type: "get",
                            url: '/auctions/' + {{ $product->id }} + '/latest-bids',
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                vm.live_bids = data;
                            },
                            error: function (xhr, status, error) {
                                if(xhr.status === 422) {
                                    vm.errors = xhr.responseJSON.errors;
                                }
                            }
                        });
                    }, 10000, vm);
                },
            }));

            Alpine.data('auction', () => ({
                bidProductFormOpen: false,
                title: '{{ $product->catalogue->title }}',
                description: '{{ $product->catalogue->description }}',
                brand: '{{ $product->brand_id }}',
                price: '{{ $product->price }}',
                unit: '{{ $product->unit_id }}',
                made_in: '{{ $product->made_in }}',
                quantity: '{{ $product->quantity }}',
                delivery_charge: '{{ $product->delivery_charge }}',
                category: '{{ $product->catalogue->category->parent_id }}',
                sub_category: '{{ $product->catalogue->category_id }}',
                errors: {},

                submit() {
                    let vm = this;
                    let formData = new FormData();
                    formData.append('title', vm.title);
                    formData.append('description', vm.description);
                    formData.append('brand', vm.brand);
                    formData.append('price', vm.price);
                    formData.append('unit', vm.unit);
                    formData.append('made_in', vm.made_in);
                    formData.append('quantity', vm.quantity);
                    formData.append('delivery_charge', vm.delivery_charge);
                    formData.append('category', vm.category);
                    formData.append('sub_category', vm.sub_category);

                    let TotalFiles = $('#images')[0].files.length; //Total files
                    let files = $('#images')[0];
                    for (let i = 0; i < TotalFiles; i++) {
                        formData.append('images[]', files.files[i]);
                    }

                    $.ajax({
                        type: "post",
                        url: '/auctions/' + {{ $product->id }} + '/submit',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            toastr.success('Bid submitted successfully', 'Success')
                        },
                        error: function (xhr, status, error) {
                            if(xhr.status === 422) {
                                vm.errors = xhr.responseJSON.errors;
                            }
                        }
                    });
                },

                toggleForm(key) {
                    if(key === this.bidProductFormOpen) { // User clicked opened form twice
                        key = false;
                    }

                    this.bidProductFormOpen = key;
                },
                resetForm() {
                    this.title = '';
                    this.description = '';
                    this.brand = '';
                    this.price = '';
                    this.unit = '';
                    this.made_in = '';
                    this.quantity = '';
                    this.delivery_charge = '';
                    this.category = '';
                    this.sub_category = '';
                }
            }))
        })
    </script>
@endsection
