<!DOCTYPE html>
<html lang="en">

@include('frontend.layouts.header')

<body>
    <!--============= ScrollToTop Section Starts Here =============-->
{{--     <div class="overlayer" id="overlayer">
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
    </div> --}}
    <a href="#0" class="scrollToTop"><i class="fas fa-angle-up"></i></a>
    <div class="overlay"></div>
    <!--============= ScrollToTop Section Ends Here =============-->
    
    @include('frontend.layouts.nav')

    @yield('breadcrumb')

    @yield('content')
    
    @include('frontend.layouts.footer')

    @include('frontend.layouts.scripts')
</body>

</html>