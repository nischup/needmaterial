<!--============= Footer Section Starts Here =============-->
<footer class="bg_img oh footer">
    <div class="footer-top-shape">

    </div>
    <div class="anime-wrapper">
        <div class="anime-1 plus-anime">
            <img src="{{ asset('frontend/images/footer/p1.png') }}" alt="footer">
        </div>
        <div class="anime-2 plus-anime">
            <img src="{{ asset('frontend/images/footer/p2.png') }}" alt="footer">
        </div>
        <div class="anime-3 plus-anime">
            <img src="{{ asset('frontend/images/footer/p3.png') }}" alt="footer">
        </div>
        <div class="anime-5 zigzag">
            <img src="{{ asset('frontend/images/footer/c2.png') }}" alt="footer">
        </div>
        <div class="anime-6 zigzag">
            <img src="{{ asset('frontend/images/footer/c3.png') }}" alt="footer">
        </div>
        <div class="anime-7 zigzag">
            <img src="{{ asset('frontend/images/footer/c4.png') }}" alt="footer">
        </div>
    </div>
    <div class="footer-top padding-bottom padding-top">
        <div class="container">
            <div class="row mb--60">
                <div class="col-sm-6 col-lg-3">
                    <div class="footer-widget widget-links">
                        <h5 class="title">Pages</h5>
                        <ul class="links-list">
                            <li>
                                <a href="{{ route('terms-condition') }}">Terms Condition</a>
                            </li>
                            <li>
                                <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="{{ route('about-us') }}">About Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="footer-widget widget-links">
                        <h5 class="title">Auctions</h5>
                        <ul class="links-list">
                            <li>
                                <a href="#0">About {{ config('app.name') }}</a>
                            </li>
                            <li>
                                <a href="#0">Our blog</a>
                            </li>
                            <li>
                                <a href="#0">Collectors' portal</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="footer-widget widget-links">
                        <h5 class="title">We're Here to Help</h5>
                        <ul class="links-list">
                            <li>
                                <a href="{{ route('dashboard') }}">Your Account</a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}">Contact Us</a>
                            </li>
                            <li>
                                <a href="{{ route('faq') }}">FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="footer-widget widget-follow">
                        <h5 class="title">Follow Us</h5>
                        <ul class="links-list">
                            <li>
                                <a href="#0"><i class="fas fa-phone-alt"></i>(646) 663-4575</a>
                            </li>
                            <li>
                                <a href="#0"><i class="fas fa-blender-phone"></i>(646) 968-0608</a>
                            </li>
                            <li>
                                <a href="#0"><i class="fas fa-envelope-open-text"></i>help@engotheme.com</a>
                            </li>
                            <li>
                                <a href="#0"><i class="fas fa-location-arrow"></i>1201 Broadway Suite</a>
                            </li>
                        </ul>
                        <ul class="social-icons">
                            <li>
                                <a href="#0" class="active"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href="#0"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#0"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#0"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="copyright-area">
                <div class="footer-bottom-wrapper">
                    <div class="logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('frontend/images/logo/footer-logo.png') }}" alt="logo"></a>
                    </div>
      
                    <div class="copyright"><p>&copy; Copyright {{ date('Y') }} | <a href="#0">Sbidu</a> By </p></div>

                </div>
            </div>
        </div>
    </div>
</footer>
<!--============= Footer Section Ends Here =============-->
