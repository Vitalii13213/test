<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        // Передаємо активні категорії до клієнтських шаблонів, навігації та navigation
        View::composer(['layouts.navbar', 'layouts.navigation', 'client.*'], function ($view) {
            $categories = Category::where('is_active', true)->get();
            $view->with('categories', $categories);
        });
    }
}
