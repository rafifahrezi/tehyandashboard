<?php

namespace App\Providers;

use App\Models\Bahan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Share low stock count with the sidebar view
        FacadesView::composer('partials.sidebar', function ($view) {
            $minimumStockThreshold = 5; 
            $lowStockCount = Bahan::where('stok_sekarang', '<=', $minimumStockThreshold)->count();
            $view->with('lowStockCount', $lowStockCount);
        });
    }

    protected $listen = [
        'Illuminate\Database\Events\ModelDeleting' => [
            'App\Listeners\DetachUserRolesBeforeDelete',
        ],
    ];
}
