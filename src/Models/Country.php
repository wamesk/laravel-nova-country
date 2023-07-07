<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Models;

use App\Models\Currency;
use App\Models\Language;
use App\Models\VatRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wame\LaravelNovaVatRate\Models\HasVatRate;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_DISABLED = 0;
    public const STATUS_ENABLED = 1;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
     * BelongsTo **********************************************************************************
     */

    /**
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_code', 'locale');
    }

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    /*
     * HasMany ************************************************************************************
     */

    /**
     * @return HasMany
     */
    public function vatRates(): HasMany
    {
        return $this->hasMany(VatRate::class, 'country_code', 'code');
    }

}
