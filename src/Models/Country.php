<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Wame\LaravelNovaCurrency\Models\HasCurrency;
use Wame\LaravelNovaLanguage\Models\HasLanguage;
use Wame\LaravelNovaVatRate\Models\VatRate;

/**
 *
 *
 * @property string $id
 * @property string|null $language_id
 * @property string|null $currency_id
 * @property string|null $continent
 * @property string|null $world_region
 * @property string $title
 * @property int $sort
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Currency|null $currency
 * @property-read Language|null $language
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country onlyTrashed()
 * @method static Builder|Country query()
 * @method static Builder|Country whereContinent($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereCurrencyId($value)
 * @method static Builder|Country whereDeletedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereLanguageId($value)
 * @method static Builder|Country whereSort($value)
 * @method static Builder|Country whereStatus($value)
 * @method static Builder|Country whereTitle($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @method static Builder|Country whereWorldRegion($value)
 * @method static Builder|Country withTrashed()
 * @method static Builder|Country withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, VatRate> $vatRates
 * @property-read int|null $vat_rates_count
 * @method static \Wame\LaravelNovaCountry\Database\Factories\CountryFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Country extends Model
{
    use HasCurrency;
    use HasFactory;
    use HasLanguage;
    use SoftDeletes;
    use HasUlids;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'title',
    ];

    protected $appends = [
        'country_data',
    ];

    public function getCountryDataAttribute(): ?\Rinvex\Country\Country
    {
        return $this->id ? country($this->id) : null;
    }

    public function vatRates(): HasMany
    {
        return $this->hasMany(VatRate::class);
    }

}
