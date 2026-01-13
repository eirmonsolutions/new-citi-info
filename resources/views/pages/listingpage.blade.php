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

<form method="GET" action="{{ route('listingpage') }}" id="listingFilterForm">

    <section class="filter-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="filter-left">

                        {{-- SEARCH --}}
                        <div class="filter-field">
                            <span class="">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                                </svg>
                            </span>

                            <input
                                type="text"
                                name="q"
                                class="filter-input"
                                placeholder="Search..."
                                value="{{ request('q') }}"
                                id="searchInput" />
                        </div>

                        {{-- LOCATION --}}
                        <div class="filter-field filter-select" data-type="location" id="locationSelect">
                            <span class="fi fi-pin"> <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 22s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z" stroke="currentColor" stroke-width="2" />
                                    <circle cx="12" cy="11" r="2.5" stroke="currentColor" stroke-width="2" />
                                </svg> </span>

                            <div class="pill-wrap" id="locationPillWrap"></div>

                            <!-- ✅ NEW: typing input -->
                            <input type="text" id="locationSearch" class="pill-input" placeholder="Type city..." autocomplete="off">

                            <input type="hidden" name="location" id="locationInput" value="{{ request('location') }}">



                            <div class="dropdown" id="locationDropdown">
                                @php $cities = ['Chicago','New York','Boston','Los Angeles']; @endphp
                                @foreach($cities as $c)
                                <button type="button" class="dd-item" data-value="{{ $c }}">{{ $c }}</button>
                                @endforeach
                            </div>
                        </div>


                        {{-- ONLINE TOGGLE --}}
                        <div class="toggle-group">
                            <label class="toggle">
                                <input type="checkbox" id="toggleOnline" name="online" value="1" {{ request('online') ? 'checked' : '' }}>
                                <span class="track"></span>
                                <span class="tlabel">Online</span>
                            </label>
                        </div>

                        {{-- RIGHT SIDE --}}
                        <div class="filter-right">

                            {{-- SORT --}}
                            <div class="sort-wrap filter-select" data-type="sort" id="sortSelect">
                                <span class="sort-label">Sort by:</span>

                                <input type="hidden" name="sort" id="sortInput" value="{{ request('sort','newest') }}">

                                <button type="button" class="sort-btn">
                                    <span id="sortValue">{{ ucfirst(str_replace('_',' ', request('sort','newest'))) }}</span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                </button>

                                <div class="dropdown" id="sortDropdown">
                                    <button type="button" class="dd-item" data-value="popular">Popular</button>
                                    <button type="button" class="dd-item" data-value="nearest">Nearest</button>
                                    <button type="button" class="dd-item" data-value="top_rated">Top Rated</button>
                                    <button type="button" class="dd-item" data-value="newest">Newest</button>
                                </div>
                            </div>

                            {{-- VIEW --}}
                            <div class="view-icons">
                                <input type="hidden" name="view" id="viewInput" value="{{ request('view','grid') }}">

                                <button type="button" class="view-btn {{ request('view','grid')=='grid'?'active':'' }}" data-view="grid" aria-label="Grid view">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M4 4h7v7H4V4Zm9 0h7v7h-7V4ZM4 13h7v7H4v-7Zm9 0h7v7h-7v-7Z" fill="currentColor"></path>
                                    </svg>
                                </button>

                                <button type="button" class="view-btn {{ request('view')=='list'?'active':'' }}" data-view="list" aria-label="List view">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M8 6h13M8 12h13M8 18h13" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                        <path d="M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor" stroke-width="4" stroke-linecap="round"></path>
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Results Count --}}
                <div class="filter-bar">
                    <div class="filter-right">
                        <div class="results">
                            Showing <span id="resultsCount">{{ $listings->total() }}</span> results
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</form>



{{-- ✅ HERE: render grid or list --}}
@if(request('view','grid') == 'list')
@include('pages.listingPage.listing_list_view', ['listings' => $listings])
@else
@include('pages.listingPage.listing_grid_view', ['listings' => $listings])
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('listingFilterForm');
        const viewInput = document.getElementById('viewInput');

        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                viewInput.value = btn.dataset.view; // grid or list
                form.submit();
            });
        });
    });
</script>

{{-- ✅ Working JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('listingFilterForm');

        // -------- Dropdown open/close ----------
        document.querySelectorAll('.filter-select').forEach(sel => {
            sel.addEventListener('click', (e) => {
                if (e.target.classList.contains('pill-x') || e.target.closest('.pill-x')) return;

                document.querySelectorAll('.filter-select.open').forEach(o => {
                    if (o !== sel) o.classList.remove('open');
                });

                sel.classList.toggle('open');
            });
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.filter-select')) {
                document.querySelectorAll('.filter-select.open').forEach(o => o.classList.remove('open'));
            }
        });

        // -------- Location pill ----------
        const locationInput = document.getElementById('locationInput');
        const locationPillWrap = document.getElementById('locationPillWrap');
        const locationDropdown = document.getElementById('locationDropdown');

        // ✅ Location typing + filter
        const locationSearch = document.getElementById('locationSearch');

        function filterLocationDropdown(term) {
            term = (term || '').toLowerCase();

            // open dropdown while typing
            document.getElementById('locationSelect').classList.add('open');

            let visibleCount = 0;

            locationDropdown.querySelectorAll('.dd-item').forEach(btn => {
                const txt = (btn.dataset.value || btn.textContent).toLowerCase();
                const match = txt.includes(term);

                btn.classList.toggle('d-none', term && !match);
                if (!term || match) visibleCount++;
            });

            // optional: if no match, show nothing
            // (you can also show a "No results" item if you want)
        }

        if (locationSearch) {
            // page load: agar already selected hai to input blank rakho
            locationSearch.value = '';

            locationSearch.addEventListener('input', (e) => {
                const term = e.target.value.trim();
                filterLocationDropdown(term);
            });

            // Enter press = first visible city select
            locationSearch.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const first = locationDropdown.querySelector('.dd-item:not(.d-none)');
                    if (first) {
                        first.click();
                    }
                }
            });
        }


        function renderLocationPill(val) {
            locationPillWrap.innerHTML = '';
            if (!val) return;

            const pill = document.createElement('span');
            pill.className = 'pill';
            pill.dataset.value = val;
            pill.innerHTML = `${val} <button type="button" class="pill-x" aria-label="Remove location">×</button>`;

            pill.querySelector('.pill-x').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                // ✅ remove location
                locationInput.value = '';
                locationPillWrap.innerHTML = ''; // pill remove instantly

                // ✅ clear typing input
                if (locationSearch) locationSearch.value = '';

                // ✅ reset dropdown filter
                locationDropdown.querySelectorAll('.dd-item').forEach(b => b.classList.remove('d-none'));

                document.getElementById('locationSelect').classList.remove('open');

                // ✅ submit form to refresh results
                form.submit();
            });


            locationPillWrap.appendChild(pill);
        }

        renderLocationPill(locationInput.value);

        if (locationDropdown) {
            locationDropdown.querySelectorAll('.dd-item').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const val = btn.dataset.value || btn.textContent.trim();
                    locationInput.value = val;
                    renderLocationPill(val);
                    document.getElementById('locationSelect').classList.remove('open');
                    form.submit();
                });
            });
        }

        // -------- Online toggle ----------
        const toggleOnline = document.getElementById('toggleOnline');
        if (toggleOnline) toggleOnline.addEventListener('change', () => form.submit());

        // -------- Sort ----------
        const sortInput = document.getElementById('sortInput');
        const sortValue = document.getElementById('sortValue');
        const sortDropdown = document.getElementById('sortDropdown');

        if (sortDropdown) {
            sortDropdown.querySelectorAll('.dd-item').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const val = btn.dataset.value;
                    sortInput.value = val;
                    sortValue.textContent = btn.textContent.trim();
                    document.getElementById('sortSelect').classList.remove('open');
                    form.submit();
                });
            });
        }

        // -------- View toggle ----------
        const viewInput = document.getElementById('viewInput');
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.view-btn').forEach(x => x.classList.remove('active'));
                btn.classList.add('active');
                viewInput.value = btn.dataset.view;
                form.submit();
            });
        });

        // -------- Search debounce submit ----------
        const searchInput = document.getElementById('searchInput');
        let t = null;
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(t);
                t = setTimeout(() => form.submit(), 500);
            });
        }
    });
</script>

@endsection