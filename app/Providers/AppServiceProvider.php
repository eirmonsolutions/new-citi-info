<?php

namespace App\Providers;

use App\Models\Wishlist;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Keep generated URLs on the same host the user is actually using
        // (fixes 419 when APP_URL says localhost but browser uses 127.0.0.1, etc.)
        if (! $this->app->runningInConsole() && $this->app->has('request')) {
            $request = $this->app->make('request');
            if ($request->getHost()) {
                URL::forceRootUrl($request->getSchemeAndHttpHost());
            }
        }

        View::composer('*', function ($view) {
            $userId = auth()->id();

            $wishlistCount = $userId
                ? \Cache::remember("wishlist_count_{$userId}", 600, fn() => Wishlist::where('user_id', $userId)->count())
                : 0;

            $view->with('wishlistCount', $wishlistCount);
        });
    }
}
