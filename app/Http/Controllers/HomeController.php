<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\BusinessListing;
use App\Models\Wishlist;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ Categories with listing count
        $categories = Category::where('is_active', 1)
            ->where('is_home', 1)
            ->withCount([
                'businessListings as listings_count' => function ($q) {
                    $q->where('is_allowed', 1)
                        ->where('status', 'published')
                        ->whereNull('deleted_at');
                }
            ])
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();

        $wishIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('business_id')->toArray() : [];

        // ✅ Fetch business listings for homepage
        $listings = BusinessListing::with(['gallery', 'hours', 'contacts'])
            ->withAvg(['reviews as avg_rating' => function ($q) {
                $q->where('is_approved', 1);
            }], 'rating')
            ->withCount(['reviews as ratings_count' => function ($q) {
                $q->where('is_approved', 1);
            }])
            ->where('status', 'published')
            ->where('is_allowed', 1)
            ->where('show_on_homepage', 1)
            ->inRandomOrder()
            ->take(6)
            ->get();

        // ✅ Fetch cities with listings count
        $cityNames = ['Melbourne', 'Sydney', 'Perth', 'Brisbane'];

        // Fetch city ids from business listings
        $cityIds = BusinessListing::whereNotNull('city')
            ->select('city')
            ->distinct()
            ->pluck('city')
            ->toArray();

        // Fetch city and their listings count
        $cities = City::whereIn('id', $cityIds)
            ->whereIn('name', $cityNames)
            ->withCount([
                'listings as listings_count' => function ($q) {
                    $q->where('is_allowed', 1)
                        ->where('status', 'published')
                        ->whereNull('deleted_at');
                }
            ])
            ->get()
            ->keyBy('name');

        // ✅ Fetch state-wise listings (for Melbourne, Sydney, Perth, Brisbane)
        $states = ['Melbourne', 'Sydney', 'Perth', 'Brisbane'];
        $stateListings = [];

        foreach ($states as $state) {
            $stateListings[$state] = BusinessListing::where('state', $state)
                ->where('status', 'published')
                ->where('is_allowed', 1)
                ->whereNull('deleted_at')
                ->count();
        }

        return view('pages.homepage', compact('categories', 'listings', 'cities', 'stateListings', 'wishIds'));
    }
}
