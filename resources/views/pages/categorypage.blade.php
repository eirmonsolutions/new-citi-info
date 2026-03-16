@extends('layouts.app')

@section('title', 'Business Categories – Australia Local Business Directory | Citiinfo')

@section('meta_description', 'Explore business categories on Citiinfo Australia. Find restaurants, salons, plumbers, hospitals, skip bin hire, towing services, real estate agents and more local businesses across Australia.')

@section('meta_keywords', '')

@section('content')


<section class="banner-area">
    <div class="container">
        <div class="banner-text">
            <h1>Explore Business Categories in Australia</h1>
        </div>
    </div>
</section>


<section class="category-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>Browse Business Categories Across Australia</h2>
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
                        <span class="listing">
                            {{ $category->listings_count }} Listing{{ $category->listings_count != 1 ? 's' : '' }}
                        </span>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection