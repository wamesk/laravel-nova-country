<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Wame\LaravelNovaCountry\Models\Country as CountryModel;
use Wame\LaravelNovaCountry\Nova\Country;
use Wame\LaravelNovaCountry\Observers\CountryObserver;

class LaravelNovaCountryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Nova::resources([
            Country::class,
        ]);

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'laravel-nova-country');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
