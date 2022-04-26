<?php

namespace App\Providers;

use App\Services\Categories;
use App\Services\CreateExcelService;
use App\Services\DecodeJson;
use App\Services\FileService;
use App\Services\PaymentService;
use App\Services\SearchItemsService;
use App\Services\TariffService;
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

        $this->app->bind('App\Services\PaymentService', function ($app) {
            return new PaymentService();
        });

        $this->app->bind('App\Services\TariffService', function ($app) {
            return new TariffService();
        });

        $this->app->singleton('App\Services\CreateExcelService', function()
        {
            $fileService = $this->app->make(FileService::class);
            $searchItemsService = $this->app->make(SearchItemsService::class);

            return new CreateExcelService($fileService, $searchItemsService);
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
