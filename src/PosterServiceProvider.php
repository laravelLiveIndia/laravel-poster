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
        $this->publishThings();
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

    protected function loadRoutesFrom($path)
    {
        $routeDir = base_path('routes');
        if (file_exists($routeDir)) {
            $appRouteDir = scandir($routeDir);
            if (!$this->app->routesAreCached()) {
                require in_array('Poster.php', $appRouteDir) ? base_path('routes/Poster.php') : $path;
            }
        } else {
            require $path;
        }
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

    public function publishTHings()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/poster'),
        ], 'poster:views');
        $this->publishes([
            __DIR__ . '/Http/routes.php' => base_path('routes/Poster.php'),
        ], 'poster:routes');
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
