<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;

class HomeController extends Controller
{

    public function index()
    {
        $categories = Category::where('is_active', 1)
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();


        return view('pages.homepage', compact('categories'));
    }
}
