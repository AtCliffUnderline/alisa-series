<?php

namespace App\Providers;

use App\Repositories\Interfaces\{FavouritesRepositoryInterface, SeriesRepositoryInterface};
use App\Repositories\{SeriesRepository, FavouritesRepository};
use App\Services\Interfaces\LostfilmParsingServiceInterface;
use App\Services\LostfilmParsingService;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Services
        $this->app->bind(LostfilmParsingServiceInterface::class,LostfilmParsingService::class);

        //Repositories
        $this->app->bind(FavouritesRepositoryInterface::class,FavouritesRepository::class);
        $this->app->bind(SeriesRepositoryInterface::class,SeriesRepository::class);
    }
}
