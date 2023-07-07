<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Rinvex\Country\CountryLoader;

/**
 * php artisan db:seed --class=CountrySeeder
 */
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $list = CountryLoader::countries();
        foreach ($list as $item) {
            $country = country($item['iso_3166_1_alpha2']);
            $currency = $country->getCurrency();
            $language = $country->getLocales();
            if (isset($language[0])) $language = str_replace('_', '-', $language[0]);

            $data = [
                'title' => $country->getName(),
                'code' => $country->getIsoAlpha2(),
                'language_code' => gettype($language) === 'string' && strlen($language) <= 5 ? $language : null,
                'currency_code' => $currency['iso_4217_code'] ?? null,
            ];

            Country::updateOrCreate(['code' => $data['code']], $data);
        }
    }
}
