<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Wame\LaravelNovaCountry\Enums\CountryStatusEnum;
use Wame\LaravelNovaCountry\Models\Country;

class CountryService extends Controller
{
    public function getActiveCodes(): Collection
    {
        return Country::whereStatus(CountryStatusEnum::ENABLED->value)->get()->pluck('id');
    }

    public function getPairs(): Collection
    {
        return Country::whereStatus(CountryStatusEnum::ENABLED->value)->get()->pluck('title', 'id');
    }

    public function getListForSelect(): array
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

    public function updateFromData(Country $country): Country
    {
        $countryCode = $country->id;

        if ($countryCode) {
            $data = country($countryCode);
            if ($data) {
                $country->continent = array_key_first($data->getGeodata()['continent']) ?? null;
                $country->title = $data->getName();
                $country->saveQuietly();
            }
        }

        return $country;
    }

    public function getWorldRegion(string $countryCode): ?string
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

    public function displayUsing($request, $model): ?string
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
