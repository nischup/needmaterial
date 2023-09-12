<div class="col-sm-10 col-md-7 col-lg-3">
    <div class="dashboard-widget mb-30 mb-lg-0">
        <div class="user">
            <div class="thumb-area">
                <div class="thumb">
                    <img src="{{ Avatar::create(auth()->user()->name)->toBase64() }}" alt="user">
                </div>
            </div>
            <div class="content">
                <h5 class="title"><a href="#0">{{ auth()->user()->name }}</a></h5>
                <span class="username">{{ auth()->user()->email }}</span>
            </div>
        </div>
        <ul class="dashboard-menu">
            <li>
                <a href="{{ route('frontend.dashboard') }}" @if(url()->current() == route('frontend.dashboard')) class="active" @endif><i class="flaticon-dashboard"></i>{{ __('Dashboard') }} </a>
            </li>
            <li>
                <a href="{{ route('frontend.profile') }}" @if(url()->current() == route('frontend.profile')) class="active" @endif><i class="flaticon-settings"></i> {{ __('Personal Profile') }} </a>
            </li>
            <li>
                <a href="{{ route('frontend.catalogue') }}" @if(url()->current() == route('frontend.catalogue')) class="active" @endif><i class="flaticon-settings"></i> {{ __('Catalogue') }} </a>
            </li>
            <li>
                <a href="{{ route('frontend.wallet') }}" @if(url()->current() == route('frontend.wallet')) class="active" @endif><i class="fas fa-wallet"></i> {{ __('Wallet') }} </a>
            </li>
            <li>
                <a href="{{ route('frontend.my-auctions') }}" @if(url()->current() == route('frontend.my-auctions')) class="active" @endif><i class="flaticon-auction"></i>{{ __('Auction list') }}</a>
            </li>

            <li class="child-menu">
                <a href="{{ route('frontend.my-auctions', ['status' => 'active']) }}" @if(url()->current() == route('frontend.my-auctions', ['status' => 'active'])) class="active" @endif>
                    {{ __('Active auctions') }} </a>
            </li>
            <li class="child-menu">
                <a href="{{ route('frontend.my-auctions', ['status' => 'closed']) }}" @if(url()->current() == route('frontend.my-auctions', ['status' => 'closed'])) class="active" @endif>
                    {{ __('Expire Auctions') }} </a>
            </li>
            <li class="child-menu">
                <a href="{{ route('frontend.my-auctions', ['status' => 'won']) }}" @if(url()->current() == route('frontend.my-auctions', ['status' => 'won'])) class="active" @endif>
                   {{ __('Complete Auctions') }} </a>
            </li>
            <li class="child-menu">
                <a href="{{ route('frontend.newAuction') }}" @if(url()->current() == route('frontend.newAuction')) class="active" @endif>
                    {{ __('New Auction') }}</a>
            </li>
            <li>
                <a href="{{ route('frontend.myBids') }}" @if(url()->current() == route('frontend.myBids')) class="active" @endif><i class="flaticon-auction"></i>{{ __('My Bids') }}</a>
            </li>            
            <li>
                <a href="{{ route('frontend.wonBids-list') }}" @if(url()->current() == route('frontend.wonBids-list')) class="active" @endif><i class="flaticon-auction"></i>{{ __('Won Bids') }}</a>
            </li>            
            <li>
                <a href="{{ route('frontend.dashboard.favorites') }}" @if(url()->current() == route('frontend.dashboard.favorites')) class="active" @endif><i class="flaticon-auction"></i>{{ __('Favorites') }}</a>
            </li>
        </ul>
    </div>
</div>
