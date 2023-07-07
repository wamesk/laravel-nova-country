<?php

namespace App\Observers;

use Wame\LaravelNovaCountry\Controllers\CountryController;
use App\Http\Controllers\v1\VatRateController;
use App\Models\Country;

class CountryObserver
{
    /**
     * Handle the Country "creating" event.
     *
     * @param Country $country
     * @return void
     */
    public function creating(Country $country)
    {
        CountryController::updateFromData($country);
    }

    /**
     * Handle the Country "created" event.
     *
     * @param Country $country
     * @return void
     */
    public function created(Country $country)
    {
        VatRateController::addVatRatesToCountry($country->code);
    }

    /**
     * Handle the Country "updating" event.
     *
     * @param Country $country
     * @return void
     */
    public function updating(Country $country)
    {
        CountryController::updateFromData($country);
    }

    /**
     * Handle the Country "updated" event.
     *
     * @param Country $country
     * @return void
     */
    public function updated(Country $country)
    {
        VatRateController::addVatRatesToCountry($country->code);
    }

    /**
     * Handle the Country "deleted" event.
     *
     * @param Country $country
     * @return void
     */
    public function deleted(Country $country)
    {
    }

    /**
     * Handle the Country "restored" event.
     *
     * @param Country $country
     * @return void
     */
    public function restored(Country $country)
    {
    }

    /**
     * Handle the Country "force deleted" event.
     *
     * @param Country $country
     * @return void
     */
    public function forceDeleted(Country $country)
    {
    }
}
