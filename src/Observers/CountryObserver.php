<?php

namespace Wame\LaravelNovaCountry\Observers;

use Wame\LaravelNovaCountry\Services\CountryService;
use Wame\LaravelNovaCountry\Models\Country;
use Wame\LaravelNovaVatRate\Actions\CountryVatRatesCreateAction;

class CountryObserver
{
    public function creating(Country $country): void
    {
        resolve(CountryService::class)->updateFromData($country);
    }

    public function created(Country $country): void
    {
        resolve(CountryVatRatesCreateAction::class)->handle($country->id);
    }

    public function updating(Country $country): void
    {
        resolve(CountryService::class)->updateFromData($country);
    }

    public function updated(Country $country): void
    {
        resolve(CountryVatRatesCreateAction::class)->handle($country->id);
    }

    public function deleted(Country $country): void
    {
    }

    public function restored(Country $country): void
    {
    }

    public function forceDeleted(Country $country): void
    {
    }
}
