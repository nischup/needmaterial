<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>404</title>

    @include('frontend.layouts.header')
</head>

<body>


<div class="overlayer" id="overlayer">
    <div class="loader">
        <div class="loader-inner"></div>
    </div>
</div>
<!--============= Error Section Starts Here =============-->
<div class="error-section padding-top padding-bottom bg_img" data-background="{{ asset('frontend/images/error-bg.png') }}">
    <div class="container">
        <div class="error-wrapper">
            <div class="error-thumb">
                <img src="{{ asset('frontend/images/error.png') }}" alt="error">
            </div>
            <h4 class="title">Return to the <a href="{{ route('home') }}">homepage</a></h4>
        </div>
    </div>
</div>
<!--============= Error Section Ends Here =============-->

@include('frontend.layouts.scripts')
</body>

</html>