<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator; // IMPORTANTE: Para as setas da paginação
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
        // 1. Corrige as setas gigantes da paginação para usar Bootstrap 5
        Paginator::useBootstrapFive();

        // 2. Compartilha as categorias com todas as views (para o menu do site)
        View::composer('*', function ($view) {
            $categories = Category::where('active', 1)
                ->orderBy('name')
                ->get();

            $view->with('menuCategories', $categories);
        });
    }
}