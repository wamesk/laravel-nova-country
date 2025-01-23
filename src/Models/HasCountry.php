<?php

namespace Wame\LaravelNovaCountry\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rinvex\Country\Country;

trait HasCountry
{
    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function countryData(): ?Country
    {
        return $this->country_id ? country($this->country_id) : null;
    }
}
