<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Country;
use Illuminate\Support\Collection;

class CountryController extends BaseController
{
    /**
     * @return Collection
     */
    public static function getActiveCountryCodes(): Collection
    {
        return Country::query()->where('deleted_at', null)->where('status', Country::STATUS_ENABLED)->get()->pluck('code');
    }

    /**
     * @return Collection
     */
    public static function getPairs(): Collection
    {
        return Country::query()->where('deleted_at', null)->where('status', Country::STATUS_ENABLED)->get()->pluck('title', 'id');
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
     * @return Country
     */
    public static function model(): Country
    {
        return new Country;
    }
}
