<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Country;
use Illuminate\Support\Collection;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;

class CountryController extends BaseController
{
    /**
     * @return Country
     */
    public static function model(): Country
    {
        return new Country;
    }

    /**
     * @return Collection
     */
    public static function getActiveCodes(): Collection
    {
        return Country::query()->where('deleted_at', null)->where('status', Country::STATUS_ENABLED)->get()->pluck('code');
    }

    /**
     * @return Collection
     */
    public static function getPairs(): Collection
    {
        return Country::query()->where('deleted_at', null)->where('status', Country::STATUS_ENABLED)->get()->pluck('title', 'code');
    }

    public static function getListForSelect()
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
        $countryCode = $country->code;

        if ($countryCode) {
            $data = country($countryCode);
            if ($data) {
                $country->continent = array_key_first($data->getGeodata()['continent']) ?? null;
                $country->world_region = self::getWorldRegion($countryCode);
                $country->title = $data->getName();
                $country->save();
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
        if (!$model->country_code) {
            return null;
        } elseif ($request instanceof ResourceIndexRequest) {
            return $model->country_code;
        } else {
            return country($model->country_code)->getName() . ' (' . $model->country_code . ')';
        }
    }

}
