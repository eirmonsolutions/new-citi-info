<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\BusinessListing;

class HomeController extends Controller
{
    public function index()
    {
        // Categories (same as before)
        $categories = Category::where('is_active', 1)
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        // ✅ FRONTEND LISTINGS (ONLY allowed + published)
        $listings = BusinessListing::where('status', 'published')
            ->where('is_allowed', 1)
            ->latest()
            ->take(8) // homepage pe kitni dikhani hain
            ->get();

        return view('pages.homepage', compact('categories', 'listings'));
    }
}
