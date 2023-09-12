@extends('frontend.layouts.master')
@section('title', 'My Favorites')
@section('breadcrumb')
    {{ Breadcrumbs::render('favorites') }}
@endsection
@section('content')
    <!--============= Dashboard Section Starts Here =============-->
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="row justify-content-center">

                @include('frontend.layouts.sidebar')

                <div class="col-lg-8">
                    <div class="dash-bid-item dashboard-widget mb-40-60">
                        <div class="header">
                            <h4 class="title">My Favorites</h4>
                        </div>
                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    <table class="table table-sm">
                                        <thead>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Photo</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach($favorites as $favorite)
                                                <tr>
                                                    <td data-purchase="item">{{ $favorite->id }}</td>
                                                    <td data-purchase="item">
                                                        <a target="_blank" href="{{ route('auction', ['slug' => $favorite->auction->slug]) }}">
                                                            {{ $favorite->auction->title }}
                                                        </a>
                                                    </td>
                                                    <td data-purchase="item"><img src="{{ $favorite->auction->thumbnail }}" width="50px" alt="no image"></td>
                                                    <td data-purchase="highest bid">{{ date("j F, g:i a", strtotime($favorite->auction->start_time)) }}</td>
                                                    <td data-purchase="lowest bid">{{ date("j F, g:i a", strtotime($favorite->auction->end_time)) }}</td>
                                                    <td data-purchase="expires">
                                                        <a href="{{ route('auction', ['slug' => $favorite->auction->slug]) }}"> View </a>
                                                        <a href="{{ route('frontend.favorites.delete', ['id' => $favorite->id]) }}"> Delete </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= Dashboard Section Ends Here =============-->
@endsection
