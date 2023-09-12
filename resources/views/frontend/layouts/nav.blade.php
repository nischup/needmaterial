<!--============= Header Section Starts Here =============-->
@push('styles')
    <style>
        .whatsapp-connect {
            display: inline-block;
            padding: 16px;
            border-radius: 8px;
            background-color: #25D366;
            color: #fff; text-decoration: none;
            font-family: sans-serif;
            font-size: 16px;
        }
    </style>
@endpush
<header>
    <div class="header-top">
        <div class="container">
            <div class="header-top-wrapper">
                <ul class="customer-support">
                    <li>
                        <a href="https://api.whatsapp.com/send?phone=3197010240285" class="mr-3"><i class="fab fa-whatsapp whatsapp"></i><span class="ml-2 d-none d-sm-inline-block">Customer Support</span></a>
                    </li>
                    <li>
                        <i class="fas fa-globe"></i>
                        <select name="language" class="select-bar" id="changeLang">
                            @php
                                $locales = get_locales();
                            @endphp
                            @if($locales)
                                @foreach($locales as $locale)
                                    <option value="{{ $locale }}" {{ session()->get('locale') == $locale ? 'selected' : '' }}>
                                        {{ strtoupper($locale) }}
                                    </option>
                                @endforeach
                            @else
                                <option value="{{ app()->getLocale() }}" selected>
                                    {{ strtoupper(app()->getLocale()) }}
                                </option>
                            @endif
                        </select>
                    </li>
                </ul>
                <ul class="cart-button-area">
                    @if(auth()->check())
                        <li>
                            <a href="{{ route('dashboard') }}" style="color: white">{{ __('Dashboard') }}</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="#" onclick="event.preventDefault();this.closest('form').submit();" style="color: white">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" style="color: white">{{ __('Sign in') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('frontend/images/logo/logo.png') }}" alt="logo">
                    </a>
                </div>
                <ul class="menu ml-auto">
                    <li>
                        <a href="{{ route('home') }}"> {{ __('Home') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('auctions') }}"> {{ __('Auction') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('quotations') }}"> {{ __('Quotation') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.pricing-plan') }}"> {{ __('Pricing Plan') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('about-us') }}">{{ __('About Us') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">{{ __('Contact') }}</a>
                    </li>
                </ul>
                <form class="search-form">
                    <input type="text" placeholder="Search for brand, model....">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                <div class="search-bar d-md-none">
                    <a href="#0"><i class="fas fa-search"></i></a>
                </div>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="text-right alert alert-success alert-dismissible fade show" role="alert" >
            @if(is_array(session('success')))
                <ul>
                    @foreach (session('success') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @else
                <strong>{{ session('success') }}</strong>
            @endif
            <button type="button" class=" text-right close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (auth()->check() && isset($complete_profile) && !$complete_profile)
        <div class="text-right alert alert-warning alert-dismissible fade show" role="alert" >
            <strong>{{ __('Please complete your profile before submit/create bid') }}</strong>
        </div>
    @endif
</header>
<!--============= Header Section Ends Here =============-->
