@extends('layouts.app')

@section('title', 'Listing Page')

@section('content')


<section class="banner-area">
    <div class="container">
        <div class="banner-text">
            <h1>Explore top-rated Listings</h1>
        </div>
    </div>
</section>

<section class="filter-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="filter-left">
                    <!-- Search -->
                    <div class="filter-field">
                        <span class="">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </span>
                        <input type="text" class="filter-input" placeholder="Physician" />
                    </div>

                    <!-- Location -->
                    <div class="filter-field filter-select" data-type="location">
                        <span class="fi fi-pin">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M12 22s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z" stroke="currentColor" stroke-width="2" />
                                <circle cx="12" cy="11" r="2.5" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </span>

                        <div class="pill-wrap" id="locationPillWrap">
                            <span class="pill" data-value="Chicago">
                                Chicago
                                <button type="button" class="pill-x" aria-label="Remove location">×</button>
                            </span>
                        </div>

                        <button type="button" class="caret" aria-label="Open location">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </button>

                        <div class="dropdown">
                            <button type="button" class="dd-item">Chicago</button>
                            <button type="button" class="dd-item">New York</button>
                            <button type="button" class="dd-item">Boston</button>
                            <button type="button" class="dd-item">Los Angeles</button>
                        </div>
                    </div>

                    <!-- Distance -->
                    <div class="filter-field filter-select" data-type="distance">
                        <span class="fi fi-nav">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M22 2 11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M22 2 15 22l-4-9-9-4 20-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </span>

                        <div class="pill-wrap" id="distancePillWrap">
                            <span class="pill" data-value="5 mi">
                                5 mi
                                <button type="button" class="pill-x" aria-label="Remove distance">×</button>
                            </span>
                        </div>

                        <button type="button" class="caret" aria-label="Open distance">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </button>

                        <div class="dropdown">
                            <button type="button" class="dd-item">1 mi</button>
                            <button type="button" class="dd-item">5 mi</button>
                            <button type="button" class="dd-item">10 mi</button>
                            <button type="button" class="dd-item">25 mi</button>
                        </div>
                    </div>

                    <!-- Toggles -->
                    <div class="toggle-group">
                        <label class="toggle">
                            <input type="checkbox" id="toggleOnline">
                            <span class="track"></span>
                            <span class="tlabel">Online</span>
                        </label>

                        <label class="toggle">
                            <input type="checkbox" id="toggleClinic">
                            <span class="track"></span>
                            <span class="tlabel">Visit clinic</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="filter-bar">
                <!-- LEFT: Filters -->


                <!-- RIGHT: Sort + view -->
                <div class="filter-right">
                    <div class="results">Showing <span id="resultsCount">56</span> results</div>




                </div>
                <div class="filter-right"> 
                    <div class="sort-wrap filter-select" data-type="sort">
                        <span class="sort-label">Sort by:</span>
                        <button type="button" class="sort-btn">
                            <span id="sortValue">Popular</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                            </svg>
                        </button>

                        <div class="dropdown">
                            <button type="button" class="dd-item">Popular</button>
                            <button type="button" class="dd-item">Nearest</button>
                            <button type="button" class="dd-item">Top Rated</button>
                            <button type="button" class="dd-item">Newest</button>
                        </div>
                    </div>
                    <div class="view-icons">
                        <button type="button" class="view-btn active" data-view="grid" aria-label="Grid view">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M4 4h7v7H4V4Zm9 0h7v7h-7V4ZM4 13h7v7H4v-7Zm9 0h7v7h-7v-7Z" fill="currentColor"></path>
                            </svg>
                        </button>
                        <button type="button" class="view-btn" data-view="list" aria-label="List view">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M8 6h13M8 12h13M8 18h13" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor" stroke-width="4" stroke-linecap="round"></path>
                            </svg>
                        </button>
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
                                <img src="" alt="{{ $listing->business_name }}" class="testimonial-avatar">
                                <div class="testimonial-text">
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($listing->description ?? ''), 40, '...') }}</p>
                                    <span class="testimonial-author">—</span>
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
    // open/close dropdowns
    document.querySelectorAll('.filter-select').forEach(sel => {
        sel.addEventListener('click', (e) => {
            // stop when clicking pill remove
            if (e.target.classList.contains('pill-x')) return;
            if (e.target.closest('.pill-x')) return;

            // close others
            document.querySelectorAll('.filter-select.open').forEach(o => {
                if (o !== sel) o.classList.remove('open');
            });
            sel.classList.toggle('open');
        });

        // select dropdown item
        sel.querySelectorAll('.dd-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                const val = item.textContent.trim();
                const type = sel.getAttribute('data-type');

                if (type === 'location') {
                    setPill('#locationPillWrap', val);
                } else if (type === 'distance') {
                    setPill('#distancePillWrap', val);
                } else if (type === 'sort') {
                    document.getElementById('sortValue').textContent = val;
                }

                sel.classList.remove('open');
            });
        });
    });

    // close on outside click
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.filter-select')) {
            document.querySelectorAll('.filter-select.open').forEach(o => o.classList.remove('open'));
        }
    });

    // pill remove
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.pill-x');
        if (!btn) return;
        btn.closest('.pill').remove();
    });

    function setPill(wrapSelector, value) {
        const wrap = document.querySelector(wrapSelector);
        wrap.innerHTML = `
      <span class="pill" data-value="${value}">
        ${value}
        <button type="button" class="pill-x" aria-label="Remove">×</button>
      </span>
    `;
    }

    // view toggle
    document.querySelectorAll('.view-btn').forEach(b => {
        b.addEventListener('click', () => {
            document.querySelectorAll('.view-btn').forEach(x => x.classList.remove('active'));
            b.classList.add('active');
            // you can add your grid/list logic here
            // console.log('view:', b.dataset.view);
        });
    });
</script>


@endsection