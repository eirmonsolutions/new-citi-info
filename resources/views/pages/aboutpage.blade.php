@extends('layouts.app')

@section('title', 'About Page')

@section('content')


<section class="banner-area-other">
    <div class="container">
        <div class="banner-text">
            <h1>About Us</h1>
        </div>
    </div>
</section>

<section class="value-about">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2>The values we live by</h2>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 gy-3 gy-md-4 gy-xl-5 gx-sm-5">
            <div class="col">
                <div class="about-value-wrapper">
                    <img src="{{ asset('assets/images/about-imgs/img-1.svg') }}" alt="">
                    <div class="about-value-content">
                        <h3>Advanced search</h3>
                        <p>Enable users to filter properties by location, price range, property type, and other key criteria for a customized search experience.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="about-value-wrapper">
                    <img src="{{ asset('assets/images/about-imgs/img-2.svg') }}" alt="">
                    <div class="about-value-content">
                        <h3>User reviews and ratings</h3>
                        <p>Enable users to filter properties by location, price range, property type, and other key criteria for a customized search experience.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="about-value-wrapper">
                    <svg class="flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="148" height="148">
                        <circle cx="64" cy="65" r="31" fill="currentColor" style="color: #fbeeee"></circle>
                        <path class="text-primary" d="M95.152 64.237c0-17.085-13.83-30.915-30.915-30.915S33.322 47.153 33.322 64.237s13.83 30.915 30.915 30.915 30.915-13.83 30.915-30.915zm6.509 0c0 1.627-.163 3.254-.326 4.881a37.71 37.71 0 0 1-6.508 16.759c-2.441 3.58-5.532 6.671-9.112 9.112-6.02 4.231-13.505 6.834-21.478 6.834-20.664 0-37.424-16.76-37.424-37.424s16.759-37.424 37.424-37.424c15.783 0 29.288 9.763 34.82 23.593 1.628 4.068 2.604 8.786 2.604 13.668z" fill="currentColor"></path>
                        <path d="M107.844 98.732l-9.112 9.112-.163.163-12.692-12.692-.163-.326c3.58-2.441 6.671-5.532 9.112-9.112l.325.163 12.691 12.692z" fill="currentColor" style="color: #fbeeee"></path>
                        <path class="text-primary" d="M119.234 110.122a6.48 6.48 0 1 1-9.275 9.274l-11.39-11.389.163-.163 9.112-9.112 11.39 11.39z" fill="currentColor"></path>
                        <path data-bs-theme="light" d="M117.932 60.983v17.898h-9.763v-9.763h-6.345-.489l.326-4.881c0-4.881-.976-9.6-2.603-13.83l.326-.163 3.905-3.905 14.644 14.644zm-39.051 0v17.898h-11.39v-9.763h-6.508v9.763h-11.39V60.983l14.644-14.644 14.644 14.644z" fill="currentColor" style="color: #fbeeee"></path>
                        <path d="M114.678 122c-1.953 0-3.742-.814-5.207-2.115l-19.2-19.363c-.325-.325-.325-.814 0-1.139s.814-.326 1.139 0l19.2 19.363c1.139 1.139 2.441 1.627 4.068 1.627 1.464 0 2.929-.651 4.068-1.627 1.138-1.139 1.627-2.441 1.627-4.068s-.651-2.929-1.627-4.068l-10.902-10.901-4.068 4.067c-.325.326-.813.326-1.139 0s-.325-.813 0-1.139l4.556-4.555c.163-.163.326-.163.651-.163.163 0 .488.163.651.163l11.389 11.389c1.465 1.302 2.116 3.255 2.116 5.207s-.814 3.743-2.116 5.207c-1.464 1.301-3.253 2.115-5.206 2.115zm-50.441-19.525C43.085 102.475 26 85.39 26 64.237S43.085 26 64.237 26s38.237 17.085 38.237 38.237-17.084 38.238-38.237 38.238zm0-74.848c-20.176 0-36.61 16.434-36.61 36.61s16.434 36.61 36.61 36.61 36.61-16.434 36.61-36.61-16.433-36.61-36.61-36.61zm0 68.339a31.67 31.67 0 0 1-31.729-31.729 31.67 31.67 0 0 1 31.729-31.729 31.67 31.67 0 0 1 31.729 31.729 31.67 31.67 0 0 1-31.729 31.729zm0-61.83c-16.597 0-30.102 13.505-30.102 30.102s13.505 30.102 30.102 30.102 30.102-13.505 30.102-30.102-13.505-30.101-30.102-30.101zm39.214 60.854c-.163 0-.488 0-.651-.163l-3.417-3.417c-.163-.163-.163-.326-.163-.651s0-.488.163-.651c.325-.325.814-.325 1.139 0l3.417 3.417c.162.163.162.326.162.651s0 .488-.162.651-.325.163-.488.163zm14.481-15.295h-9.763c-.488 0-.813-.326-.813-.814v-9.763c0-.488.325-.814.813-.814s.814.325.814.814v8.949h8.136V61.308l-14.482-14.481c-.162-.163-.162-.325-.162-.651s0-.488.162-.651c.326-.325.814-.325 1.139 0L118.42 60.17l3.255 3.254c.162.163.162.325.162.651s0 .488-.162.651c-.326.325-.814.325-1.139 0l-1.79-1.79v15.946c0 .488-.326.814-.814.814zm-39.051 0h-11.39c-.488 0-.814-.326-.814-.814v-8.949h-4.881v8.949c0 .488-.326.814-.814.814h-11.39c-.488 0-.814-.326-.814-.814V62.935l-1.79 1.79c-.326.325-.814.325-1.139 0s-.326-.814 0-1.139l17.898-17.898c.326-.325.814-.325 1.139 0l14.644 14.644 3.254 3.254c.326.326.326.814 0 1.139s-.814.325-1.139 0l-1.79-1.79v15.946c-.163.488-.488.814-.976.814zm-10.576-1.627h9.763V61.309l-13.83-13.83-13.831 13.83v16.759h9.763v-8.949c0-.488.325-.814.814-.814h6.508c.488 0 .814.325.814.814v8.949z" fill="#111827"></path>
                    </svg>
                    <div class="about-value-content">
                        <h3>Interactive map view</h3>
                        <p>Enable users to filter properties by location, price range, property type, and other key criteria for a customized search experience.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="about-value-wrapper">
                    <!-- <img src="{{ asset('assets/images/about-imgs/img-1.svg') }}" alt=""> -->
                    <div class="about-value-content">
                        <h3>listings Detailed</h3>
                        <p>Enable users to filter properties by location, price range, property type, and other key criteria for a customized search experience.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



@endsection