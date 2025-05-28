<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        //custom search macro
        Builder::macro('search', function(string $column, string $searchTerm = null) {
            $searchTerm = $searchTerm ?? request($column);
            if ($searchTerm) {
                $this->where($column, 'like', '%'.$searchTerm.'%');
            }
            return $this;
        });
    }
}
