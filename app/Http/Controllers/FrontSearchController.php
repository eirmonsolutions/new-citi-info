<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\BusinessListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class FrontSearchController extends Controller
{

    public function listingCategory($category)
    {
        $catSlug = strtolower(trim($category));

        $categoryRow = Category::whereRaw(
            "LOWER(REPLACE(TRIM(name),' ','-')) = ?",
            [$catSlug]
        )->first();

        $query = BusinessListing::query();

        if ($categoryRow) {
            $query->where('category_id', $categoryRow->id);
        } else {
            // fallback (agar categoryRow na mile)
            $query->whereRaw("LOWER(REPLACE(TRIM(category),' ','-')) = ?", [$catSlug]);
        }

        // ✅ Only ACTIVE listings show
        // (aapke table me column ka naam 'is_allowed' hai screenshot se)
        $query->where('is_allowed', 1);

        $listings = $query->latest()->paginate(12);

        $catName = $categoryRow
            ? $categoryRow->name
            : Str::title(str_replace('-', ' ', $category));

        return view('searchbar.results', [
            'listings' => $listings,
            'catName' => $catName,
            'categoryRow' => $categoryRow,
            'cityName' => null,
        ]);
    }




    public function searchRedirect(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'city_id'     => 'required|integer',
        ]);

        $category = Category::findOrFail($request->category_id);

        return redirect()->route('city.category', [
            'city'     => $request->city_id,      // ✅ ID
            'category' => Str::slug($category->name),
        ]);
    }


    // Page: /{city}/{category}
    public function listingByCityCategory($city, $category)
    {


        $cityId = (int) $city;



        $categoryRow = Category::whereRaw(
            "LOWER(REPLACE(TRIM(name),' ','-')) = ?",
            [strtolower($category)]
        )->first();


        $query = BusinessListing::query()
            ->where('city', $cityId);

        if ($categoryRow) {
            $query->where('category_id', $categoryRow->id);
        }



        $count = (clone $query)->count();



        $listings = $query->latest()->paginate(12);



        $cityName = $this->getCityNameById($cityId);
        $catName  = $categoryRow
            ? $categoryRow->name
            : Str::title(str_replace('-', ' ', $category));



        return view('searchbar.results', compact('listings', 'cityName', 'catName', 'categoryRow'));
    }




    // Suggest categories (service field)
    public function categorySuggest(Request $request)
    {
        $term = $request->get('term', '');

        $cats = Category::where('is_active', 1)
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($cats);
    }

    // Suggest cities (city field) - based on DB listings (best)
    public function citySuggest(Request $request)
    {
        $term = $request->get('term', '');
        $categoryId = $request->get('category_id');

        $q = BusinessListing::query()
            ->select('city')
            ->whereNotNull('city');

        if ($categoryId) {
            $q->where('category_id', $categoryId);
        }

        $cityIds = $q->distinct()->limit(20)->pluck('city')->toArray();

        // Ab yaha cities table se name lao
        $cities = \App\Models\City::whereIn('id', $cityIds)
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($cities);
    }

    private function getCityNameById($cityId)
    {
        // Agar aapke paas cities table hai to yaha se name fetch karo
        // Example:
        // return City::where('id', $cityId)->value('name') ?? 'City';

        return 'City'; // fallback (jab tak table confirm na ho)
    }
}
