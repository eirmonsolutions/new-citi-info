@extends('layouts.app')

@section('title', 'Citiinfo – Australia Business Directory | About Our Platform')

@section('meta_description', 'Learn about Citiinfo, an Australia business directory helping users discover local businesses and services while enabling companies to promote their listings online.')

@section('meta_keywords', '')

@section('content')


<section class="banner-area-other">
    <div class="container">
        <div class="banner-text">
            <h1>Our Blogs</h1>
        </div>
    </div>
</section>


<section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="blog-box">
                    <div class="blog-img">
                        <img src="{{ asset('assets/images/blog-imgs/blog-1/img-1.jpg') }}" alt="Citiinfo Australia Business Directory">
                    </div>
                    <div class="blog-content">
                        <div class="post-meta">
                            <span class="item-meta post-date">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock3-icon lucide-clock-3">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6h4" />
                                </svg>
                                April 16, 2026
                            </span>
                        </div>
                        <h3><a href="/citiinfo-australia-business-directory">Citiinfo Australia Business Directory: Helping Local Businesses Get Found Online</a></h3>
                        <p>
                            Explore the bold design elements and innovative features shaping today's most desirable homes. From clean lines to sustainable materials
                        </p>
                        <div class="blog-btn">
                            <a class="listing-btn" href="/citiinfo-australia-business-directory">Read More</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>




@endsection