<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Country;

class CountryController extends BaseController
{
    public static function getActiveCountryCodes()
    {
        return Country::where('deleted_at', null)->where('status', Country::STATUS_ENABLED)->get()->pluck('code');
    }

    public static function getPairs()
    {
        return Country::where('deleted_at', null)->where('status', Country::STATUS_ENABLED)->get()->pluck('title', 'id');
    }

    public static function updateFromData($countryCode)
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

    public static function getWorldRegion($countryCode)
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

}
