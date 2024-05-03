<?php

namespace Wame\LaravelNovaCountry\Observers;

use Wame\LaravelNovaCountry\Controllers\CountryController;
use Wame\LaravelNovaCountry\Models\Country;
use Wame\LaravelNovaVatRate\Controllers\VatRateController;

class CountryObserver
{
    /**
     * Handle the Country "creating" event.
     *
     * @param Country $country
     * @return void
     */
    public function creating(Country $country): void
    {
        CountryController::updateFromData($country);
    }

    /**
     * Handle the Country "created" event.
     *
     * @param Country $country
     * @return void
     */
    public function created(Country $country): void
    {
        VatRateController::addVatRatesToCountry($country->id);
    }

    /**
     * Handle the Country "updating" event.
     *
     * @param Country $country
     * @return void
     */
    public function updating(Country $country): void
    {
        CountryController::updateFromData($country);
    }

    /**
     * Handle the Country "updated" event.
     *
     * @param Country $country
     * @return void
     */
    public function updated(Country $country): void
    {
        VatRateController::addVatRatesToCountry($country->id);
    }

    /**
     * Handle the Country "deleted" event.
     *
     * @param Country $country
     * @return void
     */
    public function deleted(Country $country): void
    {
    }

    /**
     * Handle the Country "restored" event.
     *
     * @param Country $country
     * @return void
     */
    public function restored(Country $country): void
    {
    }

    /**
     * Handle the Country "force deleted" event.
     *
     * @param Country $country
     * @return void
     */
    public function forceDeleted(Country $country): void
    {
    }
}
