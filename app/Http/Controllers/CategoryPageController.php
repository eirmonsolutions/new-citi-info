<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryPageController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', 1)
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        return view('pages.categorypage', compact('categories'));
    }
}
