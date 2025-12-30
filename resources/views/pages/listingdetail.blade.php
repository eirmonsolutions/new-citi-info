@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />


<div class="breadcrumb-area">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vishal Thakur</li>
            </ol>
        </nav>
    </div>
</div>

<section class="profile-details">
    <div class="container">
        <div class="profile-wrapper">
            <div class="profile-detail-area">
                <div class="profile-img">
                    <img src="{{ asset('assets/images/saloon.jpg') }}" alt="Profile Image">
                </div>
                <div class="profile-content">
                    <div class="profile-name">
                        <h1>Vishal Thakur</h1>
                    </div>
                    <div class="profile-reviews-area">
                        <ul>
                            <li>
                                <i data-lucide="star"></i>
                                <span class="profile-review-number">4.5</span>
                                <span class="profile-review-count">(26)</span>
                            </li>
                            <li>
                                <i data-lucide="map-pin"></i>
                                <span class="profile-review-count">Delhi, India</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="profile-share-area">
                <button type="button" class="btn-2" type="button" class="btn btn-secondary"
                    data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Share">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2-icon lucide-share-2">
                        <circle cx="18" cy="5" r="3" />
                        <circle cx="6" cy="12" r="3" />
                        <circle cx="18" cy="19" r="3" />
                        <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                        <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                    </svg>
                </button>

                <button type="button" class="btn-2" type="button" class="btn btn-secondary"
                    data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Saved">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                        <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>


<section class="listing-slider">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                <!-- MAIN SLIDER (same as yours) -->
                <div class="listing-slider-wrapper mySwiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide listing-slider-single">
                            <img loading="lazy" src="{{ asset('assets/images/banner-1.jpg') }}" alt="Listing Slider">
                        </div>

                        <div class="swiper-slide listing-slider-single">
                            <img loading="lazy" src="{{ asset('assets/images/banner-2.jpg') }}" alt="Listing Slider">
                        </div>

                        <div class="swiper-slide listing-slider-single">
                            <img loading="lazy" src="{{ asset('assets/images/banner-3.jpg') }}" alt="Listing Slider">
                        </div>

                    </div>

                    <!-- scrollbar -->
                    <div class="swiper-scrollbar"></div>
                </div>

                <!-- ✅ THUMBNAILS (new) -->
                <!-- <div class="listing-thumbs mySwiperThumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide thumb-slide">
                            <img src="{{ asset('assets/images/banner-1.jpg') }}" alt="Thumb 1">
                        </div>
                        <div class="swiper-slide thumb-slide">
                            <img src="{{ asset('assets/images/banner-2.jpg') }}" alt="Thumb 2">
                        </div>
                        <div class="swiper-slide thumb-slide">
                            <img src="{{ asset('assets/images/banner-3.jpg') }}" alt="Thumb 3">
                        </div>
                    </div>
                </div> -->

            </div>

            <div class="col-lg-4">
                <div class="row row-cols-2 g-3 g-sm-4 g-md-3 g-xl-4">
                    <div class="col">
                        <div class="right-img-box">
                            <img loading="lazy" src="{{ asset('assets/images/banner-1.jpg') }}" alt="Listing Slider">
                        </div>
                    </div>
                    <div class="col">
                        <div class="right-img-box">
                            <img loading="lazy" src="{{ asset('assets/images/banner-1.jpg') }}" alt="Listing Slider">
                        </div>
                    </div>
                    <div class="col">
                        <div class="right-img-box">
                            <img loading="lazy" src="{{ asset('assets/images/banner-1.jpg') }}" alt="Listing Slider">
                        </div>
                    </div>
                    <div class="col">
                        <div class="right-img-box">
                            <img loading="lazy" src="{{ asset('assets/images/banner-1.jpg') }}" alt="Listing Slider">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="listing-details-area">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">

                <div class="ann-card ann-preview">
                    <div class="ann-card-head">Live Preview</div>
                    <div class="ann-card-body">
                        <div class="ann-preview-icon" id="pvIconWrap"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="megaphone" class="lucide lucide-megaphone">
                                <path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"></path>
                                <path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"></path>
                                <path d="M8 6v8"></path>
                            </svg></div>
                        <div class="ann-preview-texts">
                            <div id="pvTitle" class="ann-preview-title">—</div>
                            <div id="pvDesc" class="ann-preview-desc">—</div>
                        </div>
                        <span id="pvBtn" class="ann-chip">Announcement</span>
                    </div>
                </div>



                <div class="listing-details-about">
                    <h2 class="heading-title">About </h2>
                    <p>
                        I'm a skilled handyperson adept at various maintenance, repair, and installation tasks. With a keen eye for detail and a wide range of skills, I tackle diverse projects, from fixing leaky faucets and repairing electrical issues to assembling furniture and conducting minor renovations. I bring expertise and efficiency to every job, ensuring homes and spaces remain functional, safe, and aesthetically pleasing.
                    </p>
                </div>

                <div class="listing-feature-show">
                    <h2 class="heading-title">Features</h2>

                    <div class="row mt-4">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="icon-box icon-box-one">
                                <div class="icon">
                                    <i data-lucide="car"></i>
                                </div>
                                <div class="info">
                                    <h6>Card Payment</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="icon-box icon-box-one">
                                <div class="icon">
                                    <i data-lucide="star"></i>
                                </div>
                                <div class="info">
                                    <h6>Cash Payment</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="icon-box icon-box-one">
                                <div class="icon">
                                    <i data-lucide="star"></i>
                                </div>
                                <div class="info">
                                    <h6>Cash Payment</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="icon-box icon-box-one">
                                <div class="icon">
                                    <i data-lucide="car"></i>
                                </div>
                                <div class="info">
                                    <h6>Card Payment</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="icon-box icon-box-one">
                                <div class="icon">
                                    <i data-lucide="star"></i>
                                </div>
                                <div class="info">
                                    <h6>Cash Payment</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="icon-box icon-box-one">
                                <div class="icon">
                                    <i data-lucide="star"></i>
                                </div>
                                <div class="info">
                                    <h6>Cash Payment</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="listing-services-show">
                    <h2 class="heading-title">Our Services</h2>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="services-list">
                                <ul>
                                    <li>
                                        <div class="services-name">Salon</div>
                                        <div class="services-price">$20</div>
                                    </li>
                                    <li>
                                        <div class="services-name">Spa</div>
                                        <div class="services-price">$50</div>
                                    </li>
                                    <li>
                                        <div class="services-name">Massage</div>
                                        <div class="services-price">$75</div>
                                    </li>
                                    <li>
                                        <div class="services-name">Haircut</div>
                                        <div class="services-price">$15</div>
                                    </li>
                                    <li>
                                        <div class="services-name">Manicure</div>
                                        <div class="services-price">$25</div>
                                    </li>
                                    <li>
                                        <div class="services-name">Beard Cut</div>
                                        <div class="services-price">$20</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <div class="col-lg-4">
                <div class="top-sticky">
                    <div class="listing-details-sidebar">
                        <h3 class="heading-title">Contact Information</h3>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="contact-info">
                                    <ul>
                                        <li>
                                            <span class="contact-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin">
                                                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                                    <circle cx="12" cy="10" r="3" />
                                                </svg>
                                            </span>

                                            jdhsjkahdsjkaasad sdfsjdfksdfsd
                                        </li>

                                        <li>
                                            <span class="contact-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-call-icon lucide-phone-call">
                                                    <path d="M13 2a9 9 0 0 1 9 9" />
                                                    <path d="M13 6a5 5 0 0 1 5 5" />
                                                    <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                                                </svg>
                                            </span>

                                            +1 (568) 127-9712
                                        </li>

                                        <li>
                                            <span class="contact-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail">
                                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                                </svg>
                                            </span>

                                            vakucopecy@mailinator.com
                                        </li>

                                        <li>
                                            <span class="contact-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe-icon lucide-globe">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                                                    <path d="M2 12h20" />
                                                </svg>
                                            </span>

                                            https://www.fasykirat.me
                                        </li>


                                    </ul>
                                </div>

                                <div class="social-links">
                                    <a href="https://www.kun.tv" class="social-link facebook" target="_blank" rel="noopener">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook-icon lucide-facebook">
                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                        </svg>
                                    </a>

                                    <a href="https://www.cydesomajo.us" class="social-link instagram" target="_blank" rel="noopener">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram-icon lucide-instagram">
                                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                                        </svg>
                                    </a>

                                    <a href="https://www.feqofylivetaf.co.uk" class="social-link youtube" target="_blank" rel="noopener">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-youtube-icon lucide-youtube">
                                            <path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"></path>
                                            <path d="m10 15 5-3-5-3z"></path>
                                        </svg>
                                    </a>

                                    <a href="https://www.xoxujyxi.co" class="social-link twitter" target="_blank" rel="noopener">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-twitter-icon lucide-twitter">
                                            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                                        </svg>
                                    </a>

                                    <a href="https://www.firoculajery.org.uk" class="social-link linkedin" target="_blank" rel="noopener">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-linkedin-icon lucide-linkedin">
                                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                            <rect width="4" height="12" x="2" y="9"></rect>
                                            <circle cx="4" cy="4" r="2"></circle>
                                        </svg>
                                    </a>

                                    <a href="https://www.firoculajery.org.uk" class="social-link snapchat" target="_blank" rel="noopener">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-snapchat-icon lucide-snapchat">
                                            <path d="M12 2c-3.4 0-6 2.6-6 6v2.3c0 .6-.3 1.1-.8 1.4-.6.4-1.3.7-2 .9-.7.2-1.2.7-1.2 1.3 0 .7.7 1.2 1.7 1.6 1.3.5 2.2 1.2 2.8 2.1.4.6 1 .9 1.7.9h1.1c.4 0 .7.2 1 .5.5.5 1.1.8 1.7.8s1.2-.3 1.7-.8c.3-.3.6-.5 1-.5h1.1c.7 0 1.3-.3 1.7-.9.6-.9 1.5-1.6 2.8-2.1 1-.4 1.7-.9 1.7-1.6 0-.6-.5-1.1-1.2-1.3-.7-.2-1.4-.5-2-.9-.5-.3-.8-.8-.8-1.4V8c0-3.4-2.6-6-6-6z"></path>
                                        </svg>
                                    </a>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="listing-business-hour">
                        <h3 class="heading-title">Business Hour</h3>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="business-hour-list">
                                    <ul>
                                        <li>
                                            <span class="day-title">Monday</span>
                                            <span class="day-time">9:00 AM - 6:00 PM</span>
                                        </li>
                                        <li>
                                            <span class="day-title">Tuesday</span>
                                            <span class="day-time">9:00 AM - 6:00 PM</span>
                                        </li>
                                        <li>
                                            <span class="day-title">Wednesday</span>
                                            <span class="day-time">9:00 AM - 6:00 PM</span>
                                        </li>
                                        <li>
                                            <span class="day-title">Thursday</span>
                                            <span class="day-time">9:00 AM - 6:00 PM</span>
                                        </li>
                                        <li>
                                            <span class="day-title">Friday</span>
                                            <span class="day-time">9:00 AM - 6:00 PM</span>
                                        </li>
                                        <li>
                                            <span class="day-title">Saturday</span>
                                            <span class="day-time">10:00 AM - 4:00 PM</span>
                                        </li>
                                        <li>
                                            <span class="day-title">Sunday</span>
                                            <span class="day-close">Closed</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="listing-contact-form">
                        <h3 class="heading-title">Business Hour</h3>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="contact-form-wrapper">
                                    <form action="" class="row form-grid">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="user_name">Enter Your Name <span class="required">*</span></label>
                                                <input type="text" id="user_name" name="user_name" placeholder="John Doe">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="user_email">Enter Your Email <span class="required">*</span></label>
                                                <input type="text" id="user_email" name="user_email" placeholder="abcd@gmail.com">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="user_phone">Enter Your Phone Number <span class="required">*</span></label>
                                                <input type="text" id="user_phone" name="user_phone" placeholder="800-123-4567">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="user_message" class="form-label">
                                                    Message
                                                </label>
                                                <textarea id="user_message" name="user_message" class="form-control textarea-field" placeholder="Describe your business, services, and specialties" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="submit-btn">
                                                <button type="submit" class="btn-submit">Send Message</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
















<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script>
    // var swiperThumbs = new Swiper(".mySwiperThumbs", {
    //     spaceBetween: 10,
    //     slidesPerView: 5,
    //     freeMode: true,
    //     watchSlidesProgress: true,
    //     grabCursor: true,

    //     breakpoints: {
    //         0: {
    //             slidesPerView: 3
    //         },
    //         576: {
    //             slidesPerView: 4
    //         },
    //         992: {
    //             slidesPerView: 5
    //         },
    //     },
    // });

    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 12,
        loop: true,

        speed: 900,

        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },

        grabCursor: true,
        simulateTouch: true,

        scrollbar: {
            el: ".swiper-scrollbar",
            draggable: true,
            hide: false,
        },

        effect: "slide",

        // thumbs: {
        //     swiper: swiperThumbs,
        // },

        breakpoints: {
            0: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 1
            },
            1024: {
                slidesPerView: 1
            },
        },
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(el) {
            return new bootstrap.Tooltip(el);
        });
    });
</script>




@endsection