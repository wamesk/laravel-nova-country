<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Wame\LaravelNovaCountry\Enums\CountryStatusEnum;
use Wame\LaravelNovaCountry\Models\Country;

class CountryController extends Controller
{
    /**
     * @return Collection
     */
    public static function getActiveCodes(): Collection
    {
        return Country::whereStatus(CountryStatusEnum::ENABLED->value)->get()->pluck('id');
    }

    /**
     * @return Collection
     */
    public static function getPairs(): Collection
    {
        return Country::whereStatus(CountryStatusEnum::ENABLED->value)->get()->pluck('title', 'id');
    }

    public static function getListForSelect(): array
    {
        $list = self::getActiveCodes();

        $return = [];

        foreach ($list as $code) {
            $country = country($code);

            $return[$code] = $country->getName() . ' (' . $code . ')';
        }

        natcasesort($return);

        return $return;
    }

    /**
     * @param Country $country
     * @return Country
     */
    public static function updateFromData(Country $country): Country
    {
        $countryCode = $country->id;

        if ($countryCode) {
            $data = country($countryCode);
            if ($data) {
                $country->continent = array_key_first($data->getGeodata()['continent']) ?? null;
                $country->world_region = self::getWorldRegion($countryCode);
                $country->title = $data->getName();
                $country->saveQuietly();
            }
        }

        return $country;
    }

    /**
     * @param string $countryCode
     * @return string|null
     */
    public static function getWorldRegion(string $countryCode): ?string
    {
        $data = country($countryCode);
        if ($data) return null;

        if ($data->getWorldRegion() == 'AMER') {
            if ($data->getSubregion() == 'Northern America') {
                return 'NA';
            } else {
                return 'LATAM';
            }
        }

        return $data->getWorldRegion();
    }

    /**
     * Helper for display using
     *
     * @param NovaRequest $request
     * @param Country $model
     *
     * @return string|null
     */
    public static function displayUsing($request, $model): ?string
    {
        if (!$model->country_id) {
            return null;
        } elseif ($request instanceof ResourceIndexRequest) {
            return $model->country_id;
        } else {
            return country($model->country_id)->getName() . ' (' . $model->country_id . ')';
        }
    }

}
