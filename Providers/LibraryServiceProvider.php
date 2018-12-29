<?php

namespace Modules\Library\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Route;
use Modules\Library\Models\Book;
use Modules\Library\Policies\LibraryPolicy;

class LibraryServiceProvider extends ServiceProvider
{

    protected $policies = [
        Book::class => LibraryPolicy::class,
    ];


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__  . '/../Resources/views', 'Library');
        $this->loadTranslationsFrom(__DIR__  . '/../Resources/lang', 'Library');
        $this->registerConfig();
        $this->registerWebRoutes();
        $this->registerApiRoutes();
        $this->loadMigrationsFrom(__DIR__  . '/../Database/Migrations');
        $this->registerFactories();

        Gate::resource('library', 'Modules\Library\Policies\LibraryPolicy');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function registerWebRoutes()
    {
        Route::middleware('web')->namespace('Modules\Library\Http\Controllers')
            ->group(__DIR__  . '/../Routes/web.php');
    }
    public function registerApiRoutes()
    {
      Route::prefix('v1')->middleware('api')->namespace('Modules\Library\Http\Controllers')
            ->group(__DIR__  . '/../Routes/api.php');
    }
    public function registerFactories()
    {
        if (! $this->app->environment('production')) {
            $this->app->make(Factory::class)->load(__DIR__ . '/../Database/Factories');
        }
    }

     protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/library.php' => config_path('library.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/library.php', 'library'
        );
    }
}
