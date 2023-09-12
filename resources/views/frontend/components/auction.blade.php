<div class="auction-item-2">
    <div class="auction-thumb">
        <a href="{{ route('auction-product', ['slug' => $product->auction->slug, 'catalogue_slug' => $product->catalogue->slug, 'id' => $product->id,]) }}">
            <img src="{{ $product->thumbnail ? $product->thumbnail->src : asset('frontend\images\product-placeholder.webp') }}" alt="{{ $product->catalogue->title }}"></a>
        <a href="{{ route('frontend.favorites.store', ['id' => $product->id ]) }}" class="rating"><i class="far fa-star"></i></a>
        <a href="{{ route('auction-product', ['slug' => $product->auction->slug, 'catalogue_slug' => $product->catalogue->slug, 'id' => $product->id,]) }}" class="bid">
            <i class="flaticon-auction"></i></a>
    </div>
    <div class="auction-content">
        <h6 class="title">
            {{-- <a style="font-size: 16px;" href="{{ route('auction-product', ['slug' => $product->auction->slug, 'catalogue_slug' => $product->catalogue->slug, 'id' => $product->id,]) }}">{{ $product->product_title }}</a> --}}

            <a style="font-size: 16px;" href="{{ route('auction-product', ['slug' => $product->auction->slug, 'catalogue_slug' => $product->catalogue->slug, 'id' => $product->id,]) }}">{{ $product->catalogue->slug.'-'.$product->id }}</a>
        </h6>

        <div class="bid-area">
            <div class="bid-amount">
                <div class="icon">
                    <i class="flaticon-auction"></i>
                </div>
                <div class="amount-content">
                    <div class="current" style="font-size: 12px;">
                        @if ($product->auction->service_type == 1)
                            {{ __('BUYING') }}
                        @elseif ($product->auction->service_type == 2)
                            {{ __('SELLING') }}
                        @elseif ($product->auction->service_type == 3)
                            {{ __('QUOTATION') }}
                        @endif
                    </div>
                    {{-- <div class="amount">$876.00</div> --}}
                </div>
            </div>
            <div class="bid-amount">
                <div class="icon">
                    {{-- <i class="flaticon-map"></i> --}}
                    <img width="30" height="30" src="{{ asset('frontend/images/google-maps.png') }}">
                </div>
                <div class="amount-content">
                    <div class="current" style="font-size: 12px;">{{ __('Location') }}</div>
                    <div class="amount" style="font-size: 12px;"> {{ substr($product->auction->delivery_address, 0,  17) }}...</div>
                </div>
            </div>
        </div>

        <div class="countdown-area">
            <div class="countdown_{{ $product->id }}" style="font-size: 12px;">
                <div id="countdown_timer_{{ $product->id }}"></div>
            </div>
            <span class="total-bids" style="font-size: 12px;">{{ $product->bids_count }}  {{ __('Bids') }} </span>
            <span class="total-bids" style="font-size: 12px;"> {{ __('Lowest Bid') }}: {{ $product->lowest_bid ? $product->lowest_bid : '0' }}</span>
        </div>
        <div class="text-center">
            <a style="font-size: 12px;" href="{{ route('auction-product', ['slug' => $product->auction->slug, 'catalogue_slug' => $product->catalogue->slug, 'id' => $product->id,]) }}" class="custom-button">
                {{ __('Bid Now') }}
            </a>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        if ($("#countdown_timer_{{$product->id}}").length) {
            let endDate = "{{ $product->auction->end_time }}";
            let counterElement = document.querySelector(".countdown_{{$product->id}}");
            new ysCountDown(endDate, function (remaining, finished) {
                let message = "";
                if (finished) {
                    message = "{{ __('Expired') }}";
                } else {
                    var re_days = remaining.totalDays;
                    var re_hours = remaining.hours;
                    message += re_days +"d  : ";
                    message += re_hours +"h  : ";
                    message += remaining.minutes +"m  : ";
                    message += remaining.seconds + "s";
                }
                counterElement.textContent = message;
            });
        }
    </script>
@endpush
