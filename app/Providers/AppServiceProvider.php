<?php

namespace App\Providers;

use App\Repositories\Interfaces\{FavouritesRepositoryInterface, SeriesRepositoryInterface, UserRepositoryInterface};
use App\Repositories\{SeriesRepository, FavouritesRepository, UserRepository};
use App\Services\{AlisaMainService, LostfilmParsingService};
use App\Services\Interfaces\{AlisaMainServiceInterface, LostfilmParsingServiceInterface};
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
        $this->app->bind(LostfilmParsingServiceInterface::class, LostfilmParsingService::class);
        $this->app->bind(AlisaMainServiceInterface::class, AlisaMainService::class);

        //Repositories
        $this->app->bind(FavouritesRepositoryInterface::class, FavouritesRepository::class);
        $this->app->bind(SeriesRepositoryInterface::class, SeriesRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
