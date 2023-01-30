<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Database\Seeder;

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
        $languages = Language::all()->pluck('id', 'locale');
        $currencies = Currency::all()->pluck('id', 'code');

        $items = [
            ['language_id' => $languages['sk_SK'], 'currency_id' => $currencies['EUR'], 'code' => 'sk', 'iso' => 'svk', 'iso_numeric' => 203, 'title' => 'Slovensko', 'slug' => 'slovakia', 'tax' => 20],
            ['language_id' => $languages['cs_CZ'], 'currency_id' => $currencies['CZK'], 'code' => 'cz', 'iso' => 'cze', 'iso_numeric' => 703, 'title' => 'Česko', 'slug' => 'czech-republic', 'tax' => 21],
        ];

        foreach ($items as $item) {
            Country::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}
