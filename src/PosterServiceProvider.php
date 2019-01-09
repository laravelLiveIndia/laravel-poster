<?php

namespace Laravellive\Poster;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PosterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config/poster.php', 'poster');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'poster');
        $this->addConfigs();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        });
    }

    /**
    * Get the Blogg route group configuration array.
    *
    * @return array
    */
    private function routeConfiguration()
    {
        return [
            'namespace'  => "Laravellive\Poster\Http\Controllers",
            'middleware' => 'web',
        ];
    }

    public function addConfigs()
    {
        $services             = config('services');
        $services['twitter']  = config('poster.services.twitter');
        $services['facebook'] = config('poster.services.facebook');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
