<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // ✅ add
use App\Models\Wishlist;            // ✅ add

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $userId = auth()->id();

            $wishlistCount = $userId
                ? Wishlist::where('user_id', $userId)->count()
                : 0;

            $view->with('wishlistCount', $wishlistCount);
        });
    }
}
