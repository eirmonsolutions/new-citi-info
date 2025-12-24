<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\FeatureController;
use App\Http\Controllers\ListingController;
use App\Models\Feature;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Support\Facades\Artisan;

Route::get('/add-listing', [ListingController::class, 'create'])->name('listing.create');
Route::get('/submit-listing', [ListingController::class, 'create'])->name('listing.submit');
Route::post('/submit-listing', [ListingController::class, 'store'])->name('listing.store');


Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Route::get('/add-listing', function () {
//     $features = Feature::all();
//     $categories = Category::all();
//     $countries = Country::orderBy('name')->get();
//     return view('pages.addlisting', compact('categories', 'countries', 'features'));
// });


Route::get('/register', function () {
    return view('auth.register');
});



Route::post('/get-states', [ListingController::class, 'getStates'])->name('get.states');
Route::post('/get-cities', [ListingController::class, 'getCities'])->name('get.cities');




Route::middleware(['auth'])->prefix('superadmin')->name('superadmin')->group(function () {
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('.dashboard');

    Route::get('/category', [CategoryController::class, 'index'])->name('.category.index');
    Route::post('/category', [CategoryController::class, 'store'])->name('.category.store');
    Route::post('/category/{id}/update', [CategoryController::class, 'update'])->name('.category.update');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('.category.destroy');
    Route::patch('/category/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('.category.toggle-status');


    Route::get('/feature', [FeatureController::class, 'index'])->name('.feature.index');
    Route::post('/feature', [FeatureController::class, 'store'])->name('.feature.store');
    Route::post('/feature/{feature}/update', [FeatureController::class, 'update'])->name('.feature.update');
    Route::delete('/feature/{feature}', [FeatureController::class, 'destroy'])->name('.feature.destroy');
    Route::patch('/feature/{feature}/toggle-status', [FeatureController::class, 'toggleStatus'])->name('.feature.toggle-status');
});


Route::get('/clear-all-cache-now', function () {
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    Artisan::call('storage:link');

    return 'All caches cleared! <a href="/">Go Home</a>';
})->name('clear.all');
