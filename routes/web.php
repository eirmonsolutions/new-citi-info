<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingPageController;
use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\CategoryPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\FeatureController;
use App\Http\Controllers\SuperAdmin\SuperadminListingController;
use App\Http\Controllers\ListingController;
use App\Models\Feature;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SuperAdmin\SuperadminUserController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\FrontSearchController;
use App\Http\Controllers\AjaxLocationController;
// use App\Http\Controllers\Auth\GoogleAuthController;

Route::get('/add-listing', [ListingController::class, 'create'])->name('listing.create');
Route::get('/submit-listing', [ListingController::class, 'create'])->name('listing.submit');
Route::post('/submit-listing', [ListingController::class, 'store'])->name('listing.store');


Route::post('/search', [FrontSearchController::class, 'searchRedirect'])->name('search.redirect');

// Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('login.google');
// Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);


Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/about', [AboutPageController::class, 'index'])->name('aboutpage');

Route::get('/pricing-plans', function () {
    return view('pages.pricingpage');
});


Route::get('/listing', [ListingPageController::class, 'index'])->name('listingpage');
Route::get('/categories', [CategoryPageController::class, 'index'])->name('categorypage');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LogoutController::class, 'destroy'])
    ->name('logout');


Route::get('/register', function () {
    return view('auth.register');
});

// Route::get('/test-mail', function () {
//     Mail::raw('Test Email OK', function ($m) {
//         $m->to('vishaleirmon15896@gmail.com')
//             ->subject('Test Mail');
//     });

//     return 'Mail sent successfully';
// });

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
    Route::patch('/category/{id}/toggle-home', [CategoryController::class, 'toggleHome'])
        ->name('.category.toggle-home');


    Route::get('/feature', [FeatureController::class, 'index'])->name('.feature.index');
    Route::post('/feature', [FeatureController::class, 'store'])->name('.feature.store');
    Route::post('/feature/{feature}/update', [FeatureController::class, 'update'])->name('.feature.update');
    Route::delete('/feature/{feature}', [FeatureController::class, 'destroy'])->name('.feature.destroy');
    Route::patch('/feature/{feature}/toggle-status', [FeatureController::class, 'toggleStatus'])->name('.feature.toggle-status');


    Route::get('/listing', [SuperadminListingController::class, 'index'])->name('.listing.index');

    Route::patch('/listing/{listing}/approve', [SuperadminListingController::class, 'approve'])
        ->name('.listing.approve');

    Route::get('/listing/{listing}', [SuperadminListingController::class, 'show'])
        ->name('.listing.view');

    Route::delete('/listing/{listing}', [SuperadminListingController::class, 'destroy'])
        ->name('.listing.destroy');

    Route::patch('/listing/{id}/restore', [SuperadminListingController::class, 'restore'])
        ->name('.listing.restore');

    Route::patch('/listing/{listing}/toggle-allow', [SuperadminListingController::class, 'toggleAllow'])
        ->name('.listing.toggleAllow');

    Route::get('/user', [SuperadminUserController::class, 'index'])->name('.user.index');

    Route::patch('/user/{user}/toggle-status', [SuperadminUserController::class, 'toggleStatus'])
        ->name('.user.toggleStatus');

    Route::delete('/user/{user}', [SuperadminUserController::class, 'destroy'])
        ->name('.user.destroy');
});


Route::middleware(['auth'])->prefix('admin')->name('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('.dashboard');

    //   Announcement Routes
    Route::get('/announcement', [AnnouncementController::class, 'index'])->name('.announcement.index');
    Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('.announcement.create');
    Route::post('/announcement', [AnnouncementController::class, 'store'])->name('.announcement.store');

    Route::get('/announcement/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('.announcement.edit');
    Route::put('/announcement/{announcement}', [AnnouncementController::class, 'update'])->name('.announcement.update');

    Route::patch('announcement/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('.announcement.toggle');
    Route::delete('/announcement/{announcement}', [AnnouncementController::class, 'destroy'])->name('.announcement.destroy');

    // Event Routes
    Route::get('/event', [EventController::class, 'index'])->name('.event.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('.event.create');
    Route::post('/event', [EventController::class, 'store'])->name('.event.store');

    Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('.event.edit');
    Route::put('/event/{event}', [EventController::class, 'update'])->name('.event.update');

    Route::patch('event/{event}/toggle', [EventController::class, 'toggle'])->name('.event.toggle');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('.event.destroy');

    // Coupon Routes    
    Route::get('/coupon', [CouponController::class, 'index'])->name('.coupon.index');
    Route::get('/coupon/create', [CouponController::class, 'create'])->name('.coupon.create');
    Route::post('/coupon', [CouponController::class, 'store'])->name('.coupon.store');

    Route::get('/coupon/{coupon}/edit', [CouponController::class, 'edit'])->name('.coupon.edit');
    Route::put('/coupon/{coupon}', [CouponController::class, 'update'])->name('.coupon.update');

    Route::patch('coupon/{coupon}/toggle', [CouponController::class, 'toggle'])->name('.coupon.toggle');
    Route::delete('/coupon/{coupon}', [CouponController::class, 'destroy'])->name('.coupon.destroy');

    // FAQ Routes
    Route::get('/faq', [FAQController::class, 'index'])->name('.faq.index');
    Route::get('/faq/create', [FAQController::class, 'create'])->name('.faq.create');
    Route::post('/faq', [FAQController::class, 'store'])->name('.faq.store');

    Route::get('/faq/{faq}/edit', [FAQController::class, 'edit'])->name('.faq.edit');
    Route::put('/faq/{faq}', [FAQController::class, 'update'])->name('.faq.update');

    Route::delete('/faq/{faq}', [FAQController::class, 'destroy'])->name('.faq.destroy');

    // Admin Branch Listing

    Route::get('/listing', [AdminListingController::class, 'index'])->name('.listing.index');
    Route::get('/listing/{listing}/edit', [AdminListingController::class, 'edit'])->name('.listing.edit');
    Route::put('/listing/{listing}', [AdminListingController::class, 'update'])->name('.listing.update');
    Route::delete('/listing/{listing}', [AdminListingController::class, 'destroy'])->name('.listing.destroy');
    Route::get('/listings/create', [AdminListingController::class, 'create'])->name('.listings.create');
    Route::post('/listings', [AdminListingController::class, 'store'])->name('.listings.store');
});


// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
//     ->name('admin.dashboard');

Route::get('listing/{slug}', [ListingController::class, 'show'])->name('listingdetail');


// Route::get('/gd-check', function () {
//     return extension_loaded('gd') ? 'GD ENABLED ✅' : 'GD NOT ENABLED ❌';
// });

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

Route::get('/category/{category}', [FrontSearchController::class, 'listingCategory'])
    ->name('list.category');


// AJAX suggest
Route::get('/ajax/category-suggest', [FrontSearchController::class, 'categorySuggest'])->name('ajax.category.suggest');
Route::get('/ajax/city-suggest', [FrontSearchController::class, 'citySuggest'])->name('ajax.city.suggest');
Route::get('/search', [FrontSearchController::class, 'searchByText'])->name('search.byText');

// Route::get('/{city}/{category}', [FrontSearchController::class, 'listingByCityCategory'])
//     ->name('city.category');

Route::get('/ajax/city/by-coords', [AjaxLocationController::class, 'cityByCoords'])
    ->name('ajax.city.by-coords');
