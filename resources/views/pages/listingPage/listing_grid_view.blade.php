<section class="listing-area-front">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>Listings</h2>
                </div>
            </div>
        </div>
        <div class="row listing-wrapper {{ request('view','grid')=='list' ? 'is-list' : 'is-grid' }}"> @forelse($listings as $listing) <div class="{{ request('view','grid')=='list' ? 'col-12' : 'col-md-6 col-lg-4' }}">
                <div class="front-listing-box">
                    <div class="front-listing-img"> {{-- IMAGE --}} <img src="{{ $listing->logo ? asset('storage/'.$listing->logo) : 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&h=500' }}" alt="{{ $listing->business_name }}">
                        <div class="image-overlay"></div>
                        <div class="action-buttons"> <button class="action-btn" title="Save"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bookmark-icon lucide-bookmark">
                                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                                </svg> </button> </div> {{-- STATUS BADGE (optional) --}}
                        <div class="status-badge open close"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock">
                                <path d="M12 6v6l4 2" />
                                <circle cx="12" cy="12" r="10" />
                            </svg> Open Now </div>
                    </div>
                    <div class="front-listing-content">
                        <div class="front-listing-header">
                            <div class="front-listing-title">
                                <h3> {{-- VIEW LINK --}} <a href="{{ route('listingdetail', $listing->slug) }}"> {{ $listing->business_name }} </a> </h3>
                            </div>
                            <div class="front-listing-info">
                                <div class="front-listing-meta">
                                    <div class="rating"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star-icon lucide-star">
                                            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                        </svg> <span>New</span> </div>
                                    <div class="reviews"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <circle cx="9" cy="7" r="4" />
                                        </svg> <span>No ratings</span> </div>
                                </div> {{-- CATEGORY --}}
                                <div class="category-badge"> {{ $listing->categoryRel->name ?? '-' }} </div>
                            </div>
                        </div> {{-- DESCRIPTION --}}
                        <div class="testimonial">
                            <div class="testimonial-content"> <img src="" alt="{{ $listing->business_name }}" class="testimonial-avatar">
                                <div class="testimonial-text">
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($listing->description ?? ''), 40, '...') }}</p> <span class="testimonial-author">—</span>
                                </div>
                            </div>
                        </div> {{-- CITY --}}
                        <div class="location"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin">
                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                <circle cx="12" cy="10" r="3" />
                            </svg> <span> {{ $listing->cityRel->name ?? $listing->city ?? '-' }} </span> </div>
                    </div>
                </div>
            </div> @empty <div class="col-12 text-center">
                <p>No listings found.</p>
            </div> @endforelse </div>
    </div>
</section>