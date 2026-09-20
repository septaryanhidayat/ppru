<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\NavMenu;
use App\Models\Setting;
use App\Models\UnitPendidikan;
use App\Services\CmsAutoHealService;
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

        // Auto-heal unit schema if database migration is pending
        CmsAutoHealService::ensureUnitPendidikanSchemaExists();

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

        // 1. Shared Categories
        try {
            if (Schema::hasTable('categories')) {
                View::share('headerCategories', Category::withCount('posts')->orderBy('posts_count', 'desc')->take(8)->get());
            } else {
                View::share('headerCategories', collect());
            }
        } catch (\Throwable $e) {
            View::share('headerCategories', collect());
        }

        // 2. Shared Unit Pendidikan (All 8 Active Units)
        try {
            if (Schema::hasTable('unit_pendidikans')) {
                View::share('navUnitPendidikans', UnitPendidikan::active()->orderBy('order', 'asc')->get());
            } else {
                View::share('navUnitPendidikans', collect());
            }
        } catch (\Throwable $e) {
            View::share('navUnitPendidikans', collect());
        }

        // 3. Shared Nav Menus (Header & Footer)
        try {
            if (Schema::hasTable('nav_menus')) {
                View::share('headerNavMenus', NavMenu::header()->active()->root()->with('children.children')->orderBy('order', 'asc')->get());
                View::share('footerNavMenus', NavMenu::footer()->active()->root()->with('children.children')->orderBy('order', 'asc')->get());
            } else {
                View::share('headerNavMenus', collect());
                View::share('footerNavMenus', collect());
            }
        } catch (\Throwable $e) {
            View::share('headerNavMenus', collect());
            View::share('footerNavMenus', collect());
        }
    }
}
