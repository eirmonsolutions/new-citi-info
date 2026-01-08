@extends('layouts.app')

@section('title', 'Home Page')

@section('content')


<section class="banner-area">
    <div class="container">
        <div class="banner-text">
            <h1>Explore top-rated certified pros nearby</h1>
            <form action="{{ route('search.redirect') }}" method="POST" autocomplete="off">
                @csrf

                <input type="hidden" name="category_id" id="category_id">

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

                            <div id="service_suggest" class="suggest-box d-none"></div>
                        </div>

                        <hr class="vr d-none d-sm-block my-2">

                        <!-- CITY -->
                        <div class="banner-form-box zip-form-box position-relative">
                            <i class="fi-map-pin"></i>
                            <input type="text"
                                name="city"
                                id="city_input"
                                class="form-control form-control-lg form-icon-start"
                                placeholder="City"
                                required>

                            <div id="city_suggest" class="suggest-box d-none"></div>
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
                                style="width:40px;height:40px;object-fit:contain;filter: brightness(0);filter: brightness(0);">
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
            <div class="col-md-6 col-lg-4">
                <div class="front-listing-box">
                    <div class="front-listing-img">

                        {{-- IMAGE --}}
                        <img
                            src="{{ $listing->logo ? asset('storage/'.$listing->logo) : 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&h=500' }}"
                            alt="{{ $listing->business_name }}">

                        <div class="image-overlay"></div>

                        <div class="action-buttons">
                            <button class="action-btn" title="Save">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bookmark-icon lucide-bookmark">
                                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                                </svg>
                            </button>
                        </div>

                        {{-- STATUS BADGE (optional) --}}
                        <div class="status-badge open close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock">
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
                                    {{-- VIEW LINK --}}
                                    <a href="{{ route('listingdetail', $listing->slug) }}">
                                        {{ $listing->business_name }}
                                    </a>
                                </h3>
                            </div>

                            <div class="front-listing-info">
                                <div class="front-listing-meta">
                                    <div class="rating">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star-icon lucide-star">
                                            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                        </svg>
                                        <span>New</span>
                                    </div>

                                    <div class="reviews">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <circle cx="9" cy="7" r="4" />
                                        </svg>
                                        <span>No ratings</span>
                                    </div>
                                </div>

                                {{-- CATEGORY --}}
                                <div class="category-badge">
                                    {{ $listing->categoryRel->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <img src="{{ $listing->logo ? asset('storage/'.$listing->logo) : 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&h=500' }}" alt="{{ $listing->business_name }}" class="testimonial-avatar">
                                <div class="testimonial-text">
                                    <p>From start to finish, his cooperation was incredibly smooth. The pricing was quite reasonable, and the task was completed efficiently and with a high level of cleanliness. I'm delighted that we chose Mike over the other companies we considered based on quotes. </p>
                                    <!-- <span class="testimonial-author">—</span> -->
                                </div>
                            </div>
                        </div>

                        {{-- CITY --}}
                        <div class="location">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin">
                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>

                            <span>
                                {{ $listing->cityRel->name ?? $listing->city ?? '-' }}
                            </span>
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

<script>
    const serviceInput = document.getElementById('service_input');
    const serviceBox = document.getElementById('service_suggest');
    const categoryIdEl = document.getElementById('category_id');

    const cityInput = document.getElementById('city_input');
    const cityBox = document.getElementById('city_suggest');

    let serviceTimer = null;
    let cityTimer = null;

    function showBox(box) {
        box.classList.remove('d-none');
    }

    function hideBox(box) {
        box.classList.add('d-none');
        box.innerHTML = '';
    }

    serviceInput.addEventListener('input', function() {
        clearTimeout(serviceTimer);
        categoryIdEl.value = ''; // reset when typing again

        const term = this.value.trim();
        if (term.length < 1) {
            hideBox(serviceBox);
            return;
        }

        serviceTimer = setTimeout(async () => {
            const res = await fetch(`{{ route('ajax.category.suggest') }}?term=${encodeURIComponent(term)}`);
            const data = await res.json();

            if (!data.length) {
                hideBox(serviceBox);
                return;
            }

            serviceBox.innerHTML = data.map(c =>
                `<div class="suggest-item" data-id="${c.id}" data-name="${c.name}">${c.name}</div>`
            ).join('');
            showBox(serviceBox);
        }, 250);
    });

    serviceBox.addEventListener('click', function(e) {
        const item = e.target.closest('.suggest-item');
        if (!item) return;

        serviceInput.value = item.dataset.name;
        categoryIdEl.value = item.dataset.id;
        hideBox(serviceBox);

        // city suggestions ko optionally refresh kar sakte ho (category filter)
    });

    cityInput.addEventListener('input', function() {
        clearTimeout(cityTimer);

        const term = this.value.trim();
        if (term.length < 1) {
            hideBox(cityBox);
            return;
        }

        const catId = categoryIdEl.value;

        cityTimer = setTimeout(async () => {
            const url = new URL(`{{ route('ajax.city.suggest') }}`, window.location.origin);
            url.searchParams.set('term', term);
            if (catId) url.searchParams.set('category_id', catId);

            const res = await fetch(url);
            const data = await res.json();

            if (!data.length) {
                hideBox(cityBox);
                return;
            }

            cityBox.innerHTML = data.map(city =>
                `<div class="suggest-item" data-city="${city}">${city}</div>`
            ).join('');
            showBox(cityBox);
        }, 250);
    });

    cityBox.addEventListener('click', function(e) {
        const item = e.target.closest('.suggest-item');
        if (!item) return;

        cityInput.value = item.dataset.city;
        hideBox(cityBox);
    });

    // click outside hide
    document.addEventListener('click', function(e) {
        if (!serviceBox.contains(e.target) && e.target !== serviceInput) hideBox(serviceBox);
        if (!cityBox.contains(e.target) && e.target !== cityInput) hideBox(cityBox);
    });
</script>


<style>
    .suggestBox {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-top: 6px;
        overflow: hidden;
        display: none;
        z-index: 9999;
        max-height: 260px;
        overflow-y: auto;
    }

    .suggestItem {
        padding: 10px 12px;
        cursor: pointer;
        font-size: 14px;
    }

    .suggestItem:hover {
        background: #f5f5f5;
    }

    .banner-form-box {
        position: relative;
    }
</style>

@endsection