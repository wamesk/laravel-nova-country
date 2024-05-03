<?php

namespace Wame\LaravelNovaCountry\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCountry
{
    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
