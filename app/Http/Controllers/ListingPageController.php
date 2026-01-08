<?php

namespace App\Http\Controllers;

use App\Models\BusinessListing;

class ListingPageController extends Controller
{
    public function index()
    {
        $listings = BusinessListing::where('status', 'published')
            ->where('status', 'published')
            ->where('is_allowed', 1)
            ->latest()
            ->take(6) // homepage pe kitni dikhani hain
            ->get();

        return view('pages.listingpage', compact('listings'));
    }
}
