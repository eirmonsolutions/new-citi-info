@extends('layouts.app')

@section('title', 'Home Page')

@section('content')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

<!-- Banner / Search Area -->
<section class="banner-area">
    <div class="container">
        <div class="banner-text">
            <h1>Explore top-rated certified pros nearby</h1>
            <form action="{{ route('search.redirect') }}" method="POST" autocomplete="off">
                @csrf
                <input type="hidden" name="category_id" id="category_id" value="">

                <div class="banner-form">
                    <div class="banner-wrapper">

                        <!-- SERVICE -->
                        <div class="banner-form-box position-relative">
                            <i class="fi-search"></i>
                            <input type="search"
                                id="service_input"
                                class="form-control form-control-lg form-icon-start"
                                placeholder="What service do you need?"
                                required>
                            <div id="service_suggest" class="suggest-box"></div>
                        </div>

                        <hr class="vr d-sm-block">

                        <!-- CITY -->
                        <div class="banner-form-box zip-form-box position-relative">
                            <i class="fi-map-pin"></i>
                            <input type="text"
                                name="city"
                                id="city_input"
                                class="form-control form-control-lg form-icon-start"
                                placeholder="City"
                                required>
                            {{-- <button type="button" id="use-my-location" class="btn btn-sm btn-outline-secondary position-absolute end-0 top-50 translate-middle-y me-2" style="font-size:0.85rem; padding:0.35rem 0.7rem; z-index:10;">
                                📍 My location
                            </button> --}}
                            <div id="city_suggest" class="suggest-box"></div>
                            <small id="geo_msg" class="geo-msg d-none"></small>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-lg btn-primary">Search</button>
                </div>
            </form>

            <div class="category-btns">
                <button class="category-btn-link" type="button" data-service="Electrician">Electrician</button>
                <button class="category-btn-link" type="button" data-service="Plumbing">Plumbing</button>
                <button class="category-btn-link" type="button" data-service="Hospitals">Hospitals</button>
                <button class="category-btn-link" type="button" data-service="Roofing">Roofing</button>
                <button class="category-btn-link" type="button" data-service="Saloon">Saloon</button>
            </div>
        </div>
    </div>
</section>

<!-- Category Area -->
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
            <div class="category-item-grid">
                @foreach($categories as $category)
                <div class="category-item category-item-two">
                    <div class="category-img">
                        <img
                            src="{{ $category->image ? asset('storage/'.$category->image) : asset('assets/images/saloon.jpg') }}"
                            alt="{{ $category->name }}">
                        <div class="category-overlay">
                            <div class="category-content">
                                <a href="{{ route('list.category', ['category' => Str::slug($category->name)]) }}">
                                    <i class="ti-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="icon">
                            @if(!empty($category->categoryimage))
                            <img
                                src="{{ asset('storage/'.$category->categoryimage) }}"
                                alt="{{ $category->name }}"
                                style="width:40px;height:40px;object-fit:contain;filter: brightness(0);">
                            @else
                            <span>-</span>
                            @endif
                        </div>

                        <h3 class="title">
                            <a href="{{ route('list.category', ['category' => Str::slug($category->name)]) }}">
                                {{ $category->name }}
                            </a>
                        </h3>
                        <span class="listing">15 Listing</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Explore Cities Area -->
<section class="explore-city-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>Explore Cities</h2>
                </div>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-md-6 col-lg-4">
                <div class="city-grid">
                    <div class="city-img">
                        <img src="http://192.168.1.12:8000/assets/images/img-1.jpg" alt="">
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

            <div class="col-md-6 col-lg-4">
                <div class="city-grid city-grid-normal-height">
                    <div class="city-img">
                        <img src="https://images.unsplash.com/photo-1494522358652-f30e61a60313?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=500" alt="Chicago skyline with Willis Tower">
                    </div>
                    <div class="city-title">
                        <div class="listings-count">
                            <span class="count-number">3</span>
                            <p class="count-text">LISTINGS</p>
                        </div>
                        <h3><a href="#">Chicago</a></h3>
                    </div>
                </div>

                <div class="city-grid city-grid-normal-height d-sm-none d-lg-block">
                    <div class="city-img">
                        <img src="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=500" alt="Times Square in New York City">
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

            <div class="col-md-6 col-lg-4 d-lg-none d-sm-block">
                <div class="city-grid city-grid-normal-height">
                    <div class="city-img">
                        <img src="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=500" alt="Times Square in New York City">
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

            <div class="col-md-6 col-lg-4">
                <div class="city-grid">
                    <div class="city-img">
                        <img src="http://192.168.1.12:8000/assets/images/img-1.jpg" alt="">
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

<!-- Featured Listings -->
<section class="listing-area-front">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>Listings</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($listings as $listing)
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="front-listing-box">
                    <div class="front-listing-img">
                        <div class="listing-slider-wrapper mySwiper mb-5">
                            <div class="swiper-wrapper">
                                @foreach($listing->gallery as $img)
                                <div class="swiper-slide listing-slider-single">
                                    <img
                                        loading="lazy"
                                        src="{{ asset('storage/'.$img->image_path) }}"
                                        alt="{{ $img->alt_text ?? $listing->business_name }}">
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-scrollbar"></div>
                        </div>
                        <div class="image-overlay"></div>

                        <div class="action-buttons">
                            <button class="action-btn" title="Save">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bookmark">
                                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                                </svg>
                            </button>
                        </div>

                        <div class="status-badge open">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock">
                                <path d="M12 6v6l4 2" />
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            Open Now
                        </div>
                    </div>

                    <div class="front-listing-content">
                        <div class="front-listing-header">
                            <div class="front-listing-title">
                                <h3>
                                    <a href="{{ route('listingdetail', $listing->slug) }}">
                                        {{ $listing->business_name }}
                                    </a>
                                </h3>
                            </div>

                            <div class="front-listing-info">
                                <div class="front-listing-meta">
                                    <div class="rating">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star">
                                            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                        </svg>
                                        <span>4.5</span>
                                    </div>

                                    <div class="reviews">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <circle cx="9" cy="7" r="4" />
                                        </svg>
                                        <span>No ratings</span>
                                    </div>
                                </div>

                                <div class="category-badge">
                                    {{ $listing->categoryRel->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="testimonial">
                            <div class="testimonial-content">
                                <img src="{{ $listing->logo ? asset('storage/'.$listing->logo) : 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&h=500' }}" alt="{{ $listing->business_name }}" class="testimonial-avatar">
                                <div class="testimonial-text">
                                    <p>"I haven't had pizza in like 5 minutes!! talking with my colleague after our office lunch"</p>
                                    <span class="testimonial-author">Mike Johnson</span>
                                </div>
                            </div>
                        </div>

                        <div class="location">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin">
                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <span>{{ $listing->cityRel->name ?? $listing->city ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No listings found.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<section class="pricing-area">
    <div class="price-shape-one d-none d-xl-block">
        <!-- <img src="{{ asset('assets/images/pricing-shape-1.png') }}" alt=""> -->
    </div>
    <div class="container">
        <div class="pricing-wrapper">
            <div class="section-title">
                <h2>Choose Your Product.</h2>
            </div>
            <div class="tpprice-shape">
                <div class="tppricing-shape-one">
                    <img src="" alt="">
                </div>
            </div>
            <div class="row g-0 justify-content-center">

                <div class="col-md-8">
                    <div class="tp-price-toggle">
                        <div class="wrapper-full ">
                            <div class="tpprice">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="tppricing">
                                            <div class="tppricing-head">
                                                <div class="tppricing-icon tppricing-icon-1">
                                                    <img src="{{ asset('assets/images/pricing-icon-1.webp') }}" alt="">
                                                </div>
                                                <h3 class="tppricing-title">Diamond Pack</h3>
                                            </div>
                                            <div class="tppricing-content">
                                                <div class="tppricing-feature">
                                                    <ul>
                                                        <li class=""><span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                                                    <path d="M20 6 9 17l-5-5" />
                                                                </svg>
                                                            </span>999 Email</li>
                                                        <li class=""><span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                                                    <path d="M20 6 9 17l-5-5" />
                                                                </svg>
                                                            </span>3gb Hosting</li>
                                                        <li class=""><span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                                                    <path d="M20 6 9 17l-5-5" />
                                                                </svg>
                                                            </span>Email &amp; Live
                                                            chat</li>
                                                        <li class="tppricing-inactive">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                                                    <path d="M20 6 9 17l-5-5" />
                                                                </svg>
                                                            </span>1 Domain
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tppricing-price">
                                                    <h4 class="tppricing-price-title">$<!-- -->19.99</h4>
                                                </div>
                                                <div class="tppricing-btn-two">
                                                    <a class="tp-btn-blue" href="/contact">Get Started</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="tppricing">
                                            <div class="tppricing-head">
                                                <div class="tppricing-icon">
                                                    <img src="{{ asset('assets/images/pricing-icon-2.webp') }}" loading="lazy" width="22" height="30" alt="">
                                                </div>
                                                <h3 class="tppricing-title">Gold Plan</h3>
                                            </div>
                                            <div class="tppricing-content">
                                                <div class="tppricing-feature">
                                                    <ul>
                                                        <li class="">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                                                    <path d="M20 6 9 17l-5-5" />
                                                                </svg>
                                                            </span>999 Email
                                                        </li>
                                                        <li class="">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                                                    <path d="M20 6 9 17l-5-5" />
                                                                </svg>
                                                            </span>3gb Hosting
                                                        </li>
                                                        <li class="">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                                                    <path d="M20 6 9 17l-5-5" />
                                                                </svg>
                                                            </span>Email &amp; Live
                                                            chat
                                                        </li>
                                                        <li class="tppricing-inactive">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                                                    <path d="M20 6 9 17l-5-5" />
                                                                </svg>
                                                            </span>1 Domain
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tppricing-price mb-40">
                                                    <h4 class="tppricing-price-title">$<!-- -->19.99</h4>
                                                </div>
                                                <div class="tppricing-btn-two">
                                                    <a class="tp-btn-blue" href="/contact">Get Started</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── DOM Elements ───────────────────────────────────────────────
    const serviceInput = document.getElementById('service_input');
    const serviceBox = document.getElementById('service_suggest');
    const cityInput = document.getElementById('city_input');
    const cityBox = document.getElementById('city_suggest');
    const geoMsg = document.getElementById('geo_msg');
    const form = serviceInput.closest('form');

    const suggestUrl = "{{ route('ajax.category.suggest') }}";

    // ── Auto-detect location on page load ──────────────────────────
    function autoDetectLocation() {
        if (!navigator.geolocation) {
            geoMsg.textContent = "Geolocation is not supported by your browser.";
            geoMsg.classList.remove('d-none');
            return;
        }

        geoMsg.textContent = "Detecting your location...";
        geoMsg.classList.remove('d-none');

        navigator.geolocation.getCurrentPosition(
            async (position) => {
                const { latitude, longitude } = position.coords;

                try {
                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=10&addressdetails=1`
                    );

                    if (!response.ok) throw new Error('Reverse geocoding failed');

                    const data = await response.json();

                    let city = data?.address?.city ||
                               data?.address?.town ||
                               data?.address?.city_district ||
                               data?.address?.suburb ||
                               data?.address?.county ||
                               data?.address?.state ||
                               '';

                    if (city) {
                        cityInput.value = city;
                        geoMsg.textContent = `Detected: ${city}`;
                        setTimeout(() => geoMsg.classList.add('d-none'), 3500);
                    } else {
                        geoMsg.textContent = "Could not determine city name";
                    }
                } catch (err) {
                    console.error('Location detection error:', err);
                    geoMsg.textContent = "Failed to detect location";
                }
            },
            (error) => {
                let message = "Location access denied";
                if (error.code === error.PERMISSION_DENIED) {
                    message = "Please allow location access to auto-detect city";
                } else if (error.code === error.TIMEOUT) {
                    message = "Location detection timed out";
                }
                geoMsg.textContent = message;
            },
            {
                enableHighAccuracy: false,
                timeout: 7000,
                maximumAge: 60000
            }
        );
    }

    // Run location detection immediately
    autoDetectLocation();

    // ── Rest of your original code ─────────────────────────────────
    let debounceTimer;

    function show(box) { box.style.display = 'block'; }
    function hide(box) { box.style.display = 'none'; box.innerHTML = ''; }

    // Service autocomplete
    serviceInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const term = this.value.trim();

        if (term.length < 2) return hide(serviceBox);

        debounceTimer = setTimeout(async () => {
            try {
                const res = await fetch(`${suggestUrl}?term=${encodeURIComponent(term)}`);
                const { categories = [], businesses = [] } = await res.json();

                let html = '';

                if (categories.length) {
                    html += `<div class="suggest-heading">Categories</div>`;
                    html += categories.map(c => `
                        <div class="suggest-item category-item" data-slug="${c.slug}">
                            🏷 ${c.name}
                        </div>
                    `).join('');
                }

                if (businesses.length) {
                    html += `<div class="suggest-heading">Businesses</div>`;
                    html += businesses.map(b => `
                        <div class="suggest-item business-item" data-name="${b.business_name}">
                            🏢 ${b.business_name}
                        </div>
                    `).join('');
                }

                if (!html) html = `<div class="suggest-item text-muted">No results found</div>`;

                serviceBox.innerHTML = html;
                show(serviceBox);
            } catch (err) {
                console.error('Suggest error:', err);
            }
        }, 300);
    });

    // ... rest of your event listeners (suggestion click, category buttons, form submit, click outside) ...
    // Copy them from your original code if needed

    // Hide suggestions on outside click
    document.addEventListener('click', e => {
        if (!serviceBox.contains(e.target) && e.target !== serviceInput) hide(serviceBox);
        if (!cityBox.contains(e.target) && e.target !== cityInput) hide(cityBox);
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const serviceInput = document.getElementById('service_input');
        const serviceBox = document.getElementById('service_suggest');
        const cityInput = document.getElementById('city_input');
        const cityBox = document.getElementById('city_suggest');
        const form = serviceInput.closest('form');

        

        const suggestUrl = "{{ route('ajax.category.suggest') }}"; // ✅ Blade route as string

        let debounceTimer;

        function show(box) {
            box.style.display = 'block';
        }

        function hide(box) {
            box.style.display = 'none';
            box.innerHTML = '';
        }

        // 1. Service autocomplete
        serviceInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const term = this.value.trim();

            if (term.length < 2) return hide(serviceBox);

            debounceTimer = setTimeout(async () => {
                try {
                    const res = await fetch(`${suggestUrl}?term=${encodeURIComponent(term)}`);
                    const {
                        categories = [], businesses = []
                    } = await res.json();

                    let html = '';

                    if (categories.length) {
                        html += `<div class="suggest-heading">Categories</div>`;
                        html += categories.map(c => `
                        <div class="suggest-item category-item" data-slug="${c.slug}">
                            🏷 ${c.name}
                        </div>
                    `).join('');
                    }

                    if (businesses.length) {
                        html += `<div class="suggest-heading">Businesses</div>`;
                        html += businesses.map(b => `
                        <div class="suggest-item business-item" data-name="${b.business_name}">
                            🏢 ${b.business_name}
                        </div>
                    `).join('');
                    }

                    if (!html) html = `<div class="suggest-item text-muted">No results found</div>`;

                    serviceBox.innerHTML = html;
                    show(serviceBox);
                } catch (err) {
                    console.error('Suggest error:', err);
                }
            }, 300);
        });

        // Suggestion click
        serviceBox.addEventListener('click', e => {
            const item = e.target.closest('.category-item');
            if (item) {
                window.location.href = `/category/${item.dataset.slug}`;
                return;
            }

            const bizItem = e.target.closest('.business-item');
            if (bizItem) {
                serviceInput.value = bizItem.dataset.name;
                hide(serviceBox);
            }
        });

        // 2. Quick category buttons
        document.querySelectorAll('.category-btn-link').forEach(btn => {
            btn.addEventListener('click', async () => {
                const term = btn.dataset.service;
                try {
                    const res = await fetch(`${suggestUrl}?term=${encodeURIComponent(term)}`);
                    const {
                        categories = []
                    } = await res.json();

                    if (categories.length > 0) {
                        window.location.href = `/category/${categories[0].slug}`;
                    } else {
                        serviceInput.value = term;
                        form.submit();
                    }
                } catch {
                    window.location.href = `/search?service=${encodeURIComponent(term)}`;
                }
            });
        });

        // 3. Form submit
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const service = serviceInput.value.trim();
            const city = cityInput ? cityInput.value.trim() : '';

            if (!service) {
                alert("Please enter a service");
                return;
            }

            try {
                const res = await fetch(`${suggestUrl}?term=${encodeURIComponent(service)}`);
                const {
                    categories = []
                } = await res.json();

                if (categories.length > 0) {
                    window.location.href = `/category/${categories[0].slug}`;
                } else {
                    window.location.href = `/search?service=${encodeURIComponent(service)}&city=${encodeURIComponent(city)}`;
                }
            } catch (err) {
                console.error('Search error:', err);
                window.location.href = `/search?service=${encodeURIComponent(service)}`;
            }
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', e => {
            if (!serviceBox.contains(e.target) && e.target !== serviceInput) hide(serviceBox);
            if (!cityBox.contains(e.target) && e.target !== cityInput) hide(cityBox);
        });
    });
</script>



<style>
    .suggest-box {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-top: 8px;
        max-height: 260px;
        overflow-y: auto;
        z-index: 9999;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        display: none;
    }

    .suggest-item {
        padding: 12px 16px;
        cursor: pointer;
        font-size: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .suggest-item:hover,
    .suggest-item:focus {
        background: #f8f9fa;
    }

    .suggest-item:last-child {
        border-bottom: none;
    }

    .geo-msg {
        position: absolute;
        bottom: -26px;
        left: 0;
        font-size: 13.5px;
        color: #0069d9;
    }
</style>

@endsection