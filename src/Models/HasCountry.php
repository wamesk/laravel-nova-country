<?php

namespace Wame\LaravelNovaCountry\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCountry
{
    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
}
