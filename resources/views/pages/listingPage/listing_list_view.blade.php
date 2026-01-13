<div class="listing-search-area">
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                <div class="listing-here">

                    @forelse($listings as $listing)
                    <div class="listing-search-area-box">

                        {{-- LEFT: slider / image --}}
                        <div class="listing-search-box-img-area">
                            <div class="listing-slider-wrapper mySwiper">
                                <div class="swiper-wrapper">

                                    @php
                                    $gallery = $listing->gallery ?? collect([]);
                                    @endphp

                                    @if($gallery->count())
                                    @foreach($gallery as $img)
                                    <div class="swiper-slide listing-slider-single">
                                        <img loading="lazy"
                                            src="{{ asset('storage/'.$img->image_path) }}"
                                            alt="{{ $img->alt_text ?? $listing->business_name }}">
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="swiper-slide listing-slider-single">
                                        <img loading="lazy"
                                            src="{{ $listing->logo ? asset('storage/'.$listing->logo) : 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&h=500' }}"
                                            alt="{{ $listing->business_name }}">
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: content --}}
                        <div class="listing-search-box-content-area">
                            <h3>
                                <a href="{{ route('listingdetail', $listing->slug) }}">
                                    {{ $listing->business_name }}
                                </a>
                            </h3>

                            <div class="profile-reviews-area">
                                <ul>
                                    <li>
                                        <i data-lucide="star"></i>
                                        <span class="profile-review-number">4.5</span>
                                        <span class="profile-review-count">(26)</span>
                                    </li>

                                    <li>
                                        <i data-lucide="map-pin" style="color:#6c727f;fill:transparent;"></i>
                                        <span class="profile-review-count">
                                            {{ $listing->cityRel->name ?? '' }}
                                            @if($listing->stateRel?->name), {{ $listing->stateRel->name }} @endif
                                            @if($listing->countryRel?->name), {{ $listing->countryRel->name }} @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <div class="services-list">
                                <ul>
                                    @forelse($listing->services as $service)
                                    <li>
                                        <div class="services-name"> {{ $service->name }}</div>
                                    </li>
                                    @empty
                                    <li>
                                        <div class="services-name">No services found</div>
                                    </li>
                                    @endforelse
                                </ul>
                            </div>

                            @php
                            $phone = optional($listing->contacts->first())->phone;
                            $wa = $phone ? preg_replace('/\D/', '', $phone) : null;
                            @endphp

                            <div class="listing-search-box-social-links">
                                <ul>
                                    @if($phone)
                                    <li>
                                        <a href="tel:{{ $phone }}" class="call-btn">
                                            {{ $phone }}
                                        </a>
                                    </li>

                                    <li>
                                        <a target="_blank" href="https://wa.me/{{ $wa }}" class="whatsaap-btn">
                                            WhatsApp
                                        </a>
                                    </li>
                                    @endif

                                    <li>
                                        <a href="#" class="send-enquiry-btn">Send Enquiry</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="wishlist-icon">
                            <a href="#"><i data-lucide="heart"></i></a>
                        </div>

                    </div>
                    @empty
                    <div class="alert alert-warning">No listings found.</div>
                    @endforelse

                    <div class="mt-3">
                        {{ $listings->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


{{-- ✅ Swiper (only for list view) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".mySwiper").forEach(function(swiperEl) {
            const randomDelay = Math.floor(Math.random() * (15000 - 8000 + 1)) + 3000;

            new Swiper(swiperEl, {
                slidesPerView: 1,
                spaceBetween: 12,
                loop: true,
                speed: 900,
                autoplay: {
                    delay: randomDelay,
                    disableOnInteraction: false
                },
                grabCursor: true,
                simulateTouch: true,
                effect: "slide",
            });
        });
    });
</script>