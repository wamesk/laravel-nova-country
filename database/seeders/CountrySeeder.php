<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Database\Seeders;

use Illuminate\Database\Seeder;
use Rinvex\Country\CountryLoader;
use Rinvex\Country\CountryLoaderException;
use Wame\LaravelNovaCountry\Models\Country;

/**
 * php artisan db:seed --class=CountrySeeder
 */
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws CountryLoaderException
     */
    public function run(): void
    {
        $list = CountryLoader::countries();
        foreach ($list as $item) {
            $country = country($item['iso_3166_1_alpha2']);
            $currency = $country->getCurrency();
            $language = $country->getLocales();
            if (isset($language[0])) {
                $language = str_replace('_', '-', $language[0]);
            }

            $data = [
                'id' => $country->getIsoAlpha2(),
                'title' => $country->getName(),
                'language_id' => (gettype($language) === 'string' && strlen($language) <= 5) ? $language : null,
                'currency_id' => $currency['iso_4217_code'] ?? null,
            ];

            Country::query()->updateOrCreate(['id' => $data['id']], $data);
        }
    }
}
