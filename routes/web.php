<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\LogoutController;
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


// Route::get('/test-mail', function () {
//     Mail::raw('Test Email OK', function ($m) {
//         $m->to('vishaleirmon15896@gmail.com')
//           ->subject('Test Mail');
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


    // Route::get('/announcement', [AnnouncementController::class, 'index'])->name('.announcement.index');
    // Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('.announcement.create');
    // Route::post('/announcement', [AnnouncementController::class, 'store'])->name('.announcement.store');



    Route::get('/announcement', [AnnouncementController::class, 'index'])->name('.announcement.index');
    Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('.announcement.create');
    Route::post('/announcement', [AnnouncementController::class, 'store'])->name('.announcement.store');

    Route::get('/announcement/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('.announcement.edit');
    Route::put('/announcement/{announcement}', [AnnouncementController::class, 'update'])->name('.announcement.update');

    Route::patch('announcement/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('.announcement.toggle');
    Route::delete('/announcement/{announcement}', [AnnouncementController::class, 'destroy'])->name('.announcement.destroy');
});



// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
//     ->name('admin.dashboard');





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
