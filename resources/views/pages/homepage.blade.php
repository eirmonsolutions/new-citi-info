@extends('layouts.app')

@section('title', 'Home Page')

@section('content')


<section class="banner-area">
    <div class="container">
        <div class="banner-text">
            <h1>Explore top-rated certified pros nearby</h1>
            <form action="">
                <div class="banner-form ">
                    <div class="banner-wrapper">
                        <div class="banner-form-box">
                            <i class="fi-search"></i>
                            <input type="search" class="form-control form-control-lg form-icon-start" placeholder="What service do you need?" required>
                        </div>
                        <hr class="d-sm-none m-0">
                        <hr class="vr d-none d-sm-block my-2">
                        <div class="banner-form-box zip-form-box">
                            <i class="fi-map-pin"></i>
                            <input type="text" class="form-control form-control-lg form-icon-start" placeholder="City" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary">Search</button>
                </div>
            </form>
            <div class="category-btns">
                <button class="category-btn-link" type="button">Electrician</button>
                <button class="category-btn-link" type="button">Plumbing</button>
                <button class="category-btn-link" type="button">Hospitals</button>
                <button class="category-btn-link" type="button">Roofing</button>
                <button class="category-btn-link" type="button">Saloon</button>
            </div>
        </div>
    </div>
</section>


<section class="category-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>Destination Category</h2>
                </div>
            </div>
        </div>

        <div class="row">

            @foreach($categories as $category)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="category-item category-item-two">
                    <div class="category-img">
                        <img
                            src="{{ $category->image ? asset('storage/'.$category->image) : asset('assets/images/saloon.jpg') }}"
                            alt="{{ $category->name }}">
                        <div class="category-overlay">
                            <div class="category-content">
                                <a href="{{ url('category/'.$category->id) }}">
                                    <i class="ti-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="icon">
                            <i class="{{ $category->icon ?? 'flaticon-government' }}"></i>
                        </div>
                        <h3 class="title">
                            <a href="{{ url('category/'.$category->id) }}">
                                {{ $category->name }}
                            </a>
                        </h3>
                        <span class="listing">15 Listing</span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>


<section class="explore-city-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>Explore Cities</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="cities.html">
                    <div class="city-grid">
                        <div class="city-img">
                            <img src="{{ asset('assets/images/img-1.jpg') }}" alt="">
                        </div>
                        <div class="city-title">
                            <div class="listings-count">
                                <span class="count-number">3</span>
                                <p class="count-text">LISTINGS</p>
                            </div>
                            <h3><a href="#">Chicago</a></h3>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-md-4 p-0">
                <div class="city-grid city-grid-normal-height">
                    <div class="city-img">
                        <img src="https://images.unsplash.com/photo-1494522358652-f30e61a60313?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=500"
                            alt="Chicago skyline with Willis Tower">
                    </div>
                    <div class="city-title">
                        <div class="listings-count">
                            <span class="count-number">3</span>
                            <p class="count-text">LISTINGS</p>
                        </div>
                        <h3><a href="#">Chicago</a></h3>
                    </div>
                </div>
                <div class="city-grid city-grid-normal-height">
                    <div class="city-img">
                        <img src="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=500"
                            alt="Times Square in New York City">
                    </div>
                    <div class="city-title">
                        <div class="listings-count">
                            <span class="count-number">3</span>
                            <p class="count-text">LISTINGS</p>
                        </div>
                        <h3><a href="#">Chicago</a></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="city-grid">
                    <div class="city-img">
                        <img src="{{ asset('assets/images/img-1.jpg') }}" alt="">
                    </div>
                    <div class="city-title">
                        <div class="listings-count">
                            <span class="count-number">3</span>
                            <p class="count-text">LISTINGS</p>
                        </div>
                        <h3><a href="#">Chicago</a></h3>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection