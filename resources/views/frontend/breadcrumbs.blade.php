@unless ($breadcrumbs->isEmpty())
<div class="hero-section">
    <div class="container">
        <ul class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)

                @if (!is_null($breadcrumb->url) && !$loop->last)
                    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li><span>{{ $breadcrumb->title }}</span></li>
                @endif
            @endforeach
        </ul>
    </div>
{{--    <div class="bg_img hero-bg bottom_center" data-background="{{ asset('frontend/images/banner/hero-bg.png') }}"></div>--}}
{{--    <div class="bg_img hero-bg bottom_center" data-background=""></div>--}}
</div>
@endunless
