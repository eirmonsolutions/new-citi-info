@extends('layouts.app')

@section('title', 'Listing Page')

@section('content')


<section class="banner-area">
    <div class="container">
        <div class="banner-text">
            <h1>Explore categories</h1>
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
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection