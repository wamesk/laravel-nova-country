<?php

namespace Wame\LaravelNovaCountry\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wame\LaravelNovaCountry\Models\Country;

trait HasCountry
{
    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function countryData(): ?\Rinvex\Country\Country
    {
        return $this->country_id ? country($this->country_id) : null;
    }
}
