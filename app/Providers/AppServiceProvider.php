<?php

namespace App\Providers;

use App\Services\Categories;
use App\Services\DecodeJson;
use App\Services\FileService;
use App\Services\SearchItemsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\DecodeJson', function ($app) {
            return new DecodeJson();
        });

        $this->app->singleton('App\Services\Categories', function()
        {
            $decodeJson = $this->app->make(DecodeJson::class);

            return new Categories($decodeJson);
        });

        $this->app->bind('App\Services\FileService', function ($app) {
            return new FileService();
        });

        $this->app->singleton('App\Services\SearchItemsService', function()
        {
            $decodeJson = $this->app->make(DecodeJson::class);

            return new SearchItemsService($decodeJson);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
