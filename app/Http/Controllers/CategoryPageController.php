<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Category;

class CategoryPageController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', 1)
            ->withCount([
                'businessListings as listings_count' => function ($q) {
                    $q->where('is_allowed', 1)
                        ->where('status', 'published')
                        ->whereNull('deleted_at');
                }
            ])
            ->orderBy('id', 'desc')
            ->get();


        $cityNames = ['Melbourne', 'Sydney', 'Perth', 'Brisbane'];

        $cities = City::whereIn('name', $cityNames)
            ->withCount([
                'listings as listings_count' => function ($q) {
                    $q->where('is_allowed', 1)
                        ->where('status', 'published')
                        ->whereNull('deleted_at');
                }
            ])
            ->get()
            ->keyBy('name'); // ✅ access by city name

        return view('pages.categorypage', compact('categories', 'cities'));
    }
}
