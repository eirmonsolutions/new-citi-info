<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessListing;

class ListingPageController extends Controller
{
    public function index(Request $request)
    {
        // GET filters
        $q        = trim($request->get('q', ''));
        $location = trim($request->get('location', ''));
        $online   = $request->boolean('online');
        $sort     = $request->get('sort', 'newest');   // popular|top_rated|newest|nearest
        $view     = $request->get('view', 'grid');     // grid|list

        $query = BusinessListing::query()
            ->where('status', 'published')
            ->where('is_allowed', 1);

        // ✅ Search
        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('business_name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // ✅ Location (safe: if cityRel relation exists)
        if ($location !== '') {
            $query->where(function ($qq) use ($location) {
                if (method_exists(BusinessListing::class, 'cityRel')) {
                    $qq->whereHas('cityRel', function ($c) use ($location) {
                        $c->where('name', $location);
                    });
                }

                // fallback (text column)
                $qq->orWhere('city', $location);
            });
        }

        // ✅ Online (agar column exist hai)
        if ($online && \Schema::hasColumn('business_listings', 'is_online')) {
            $query->where('is_online', 1);
        }

        // ✅ Sorting (agar columns exist hain)
        if ($sort === 'popular' && \Schema::hasColumn('business_listings', 'views')) {
            $query->orderByDesc('views')->orderByDesc('id');
        } elseif ($sort === 'top_rated' && \Schema::hasColumn('business_listings', 'avg_rating')) {
            $query->orderByDesc('avg_rating')->orderByDesc('id');
        } else {
            // newest/nearest fallback
            $query->latest();
        }

        // ✅ IMPORTANT: paginate use karo so Blade me total() chale
        $listings = $query->paginate(12)->withQueryString();

        return view('pages.listingpage', compact('listings', 'q', 'location', 'online', 'sort', 'view'));
    }
}
