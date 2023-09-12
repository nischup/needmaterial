@extends('frontend.layouts.master')
@section('title', 'Profile')
@section('breadcrumb')
    {{ Breadcrumbs::render('profile') }}
@endsection
@section('content')
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="row justify-content-center">

                @include('frontend.layouts.sidebar')

                <div class="col-lg-8">
                       <div class="col-12">
                            <div class="dash-pro-item mb-30 dashboard-widget">
                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-8">
                                        <h4 class="title">Account Settings </h4>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="float-right" href="{{ route('frontend.profile') }}">{{ __('Edit') }}</a>
                                    </div>
                                </div>
                                <ul class="dash-pro-body">
                                    <li>
                                        <div class="info-name">Company</div>
                                        <div class="info-value">
                                            <span> {{ optional($profile->company)->name }}</span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="info-name">Country</div>
                                        <div class="info-value">
                                            <span> {{ $profile->country_name }} </span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="info-name">City</div>
                                        <div class="info-value">
                                        <span>   <span> {{ $profile->city_name }} </span> </span>
                                        </div>
                                    </li>

                                    @if (!empty($neighbour->title))
                                     <li>
                                        <div class="info-name">Neighbourhood </div>
                                        <div class="info-value">
                                            <span>{{ $neighbour->title }}</span>
                                        </div>
                                    </li>
                                    @endif

                                        <li>
                                            <div class="info-name">Registration No </div>
                                            <div class="info-value">
                                            <span>{{ $profile->registration }}</span>
                                            </div>
                                        </li>

                                   {{--      <li>
                                            <div class="info-name">Company Phone</div>
                                            <div class="info-value">
                                                <span> {{ $profile->company_phone }}</span>
                                            </div>
                                        </li> --}}

                                 @if (auth()->user()->user_type == 2)
                                    <li>
                                            <div class="info-name"> {{ __('Category') }} </div>
                                            <div class="info-value">
                                                <?php
                                                    $cat_dtls = '';
                                                    foreach ($cat as $cat_data)
                                                    {
                                                        if($cat_dtls != '')
                                                        {
                                                            $cat_dtls .= ', ';
                                                        }
                                                        $cat_dtls .= $cat_data->name_en;
                                                    }
                                                ?>
                                                <span> {{ $cat_dtls }}</span>
                                        </li>
                                    @endif
                                </ul>
                                <div class="row">
                                    @if($profile->reg_copy_doc_download)
                                    <div class="col-md-6">
                                        <img src="{{ $profile->reg_copy_doc_download }}" width="250" download>
                                        {{-- <img src="{{ asset('frontend/images/document.png') }}" width="250" download> --}}
                                        <a href="{{ $profile->reg_copy_doc_download }}" download> Download Reg Certificate</a>
                                    </div>
                                    @endif      

                                    @if($profile->vat_copy_doc_download)
                                    <div class="col-md-6">
                                        <img src="{{ $profile->vat_copy_doc_download }}" width="250" download>
                                        <a href="{{ $profile->vat_copy_doc_download }}" download> Download Reg Certificate</a>
                                    </div>
                                    @endif

                                </div>


                            </div>

                        </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= Dashboard Section Ends Here =============-->
@endsection
@section('scripts')
    @livewireScripts
@endsection
