<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\BusinessListing;

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

        // ✅ FRONTEND LISTINGS (ONLY allowed + published)
        $listings = BusinessListing::with(['gallery', 'hours']) // ✅ add this
            ->where('status', 'published')
            ->where('is_allowed', 1)
            ->latest()
            ->take(6)
            ->get();


        $cityNames = ['Melbourne', 'Sydney', 'Perth', 'Brisbane'];

        $cityIds = BusinessListing::whereNotNull('city')
            ->select('city')
            ->distinct()
            ->pluck('city')
            ->toArray();

        $cities = City::whereIn('id', $cityIds)
            ->whereIn('name', ['Melbourne', 'Sydney', 'Perth', 'Brisbane'])
            ->withCount([
                'listings as listings_count' => function ($q) {
                    $q->where('is_allowed', 1)
                        ->where('status', 'published')
                        ->whereNull('deleted_at');
                }
            ])
            ->get()
            ->keyBy('name');


        return view('pages.homepage', compact('categories', 'listings', 'cities'));
    }
}
