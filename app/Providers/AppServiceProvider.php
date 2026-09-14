<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\UnitPendidikan;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        if (config('app.env') === 'production' || str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('settings')) {
                    $view->with('siteSettings', Setting::all()->pluck('value', 'key')->toArray());

                    return;
                }
            } catch (\Throwable $e) {
                // Database not yet connected or migrating
            }
            $view->with('siteSettings', []);
        });

        try {
            if (Schema::hasTable('categories')) {
                $headerCategories = Category::withCount('posts')
                    ->orderBy('posts_count', 'desc')
                    ->take(8)
                    ->get();
                View::share('headerCategories', $headerCategories);
            } else {
                View::share('headerCategories', collect());
            }

            if (Schema::hasTable('unit_pendidikans')) {
                View::share('navUnitPendidikans', UnitPendidikan::active()->orderBy('order', 'asc')->get());
            } else {
                View::share('navUnitPendidikans', collect());
            }
        } catch (\Throwable $e) {
            View::share('headerCategories', collect());
            View::share('navUnitPendidikans', collect());
        }
    }
}
