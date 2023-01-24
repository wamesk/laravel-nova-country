<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Database\Seeder;


/**
 * php artisan db:seed --class=LanguageSeeder
 */
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = Language::all()->pluck('locale', 'id');
        $currencies = Currency::all()->pluck('code', 'id');

        $items = [
            ['language_id' => $languages['sk_SK'], 'currency_id' => $currencies['EUR'], 'code' => 'sk', 'iso' => 'svk', 'iso_numeric' => 203, 'title' => 'Slovensko', 'slug' => 'slovakia', 'tax' => 21],
            ['language_id' => $languages['cs_CZ'], 'currency_id' => $currencies['CZK'], 'code' => 'cz', 'iso' => 'cze', 'iso_numeric' => 703, 'title' => 'Česko', 'slug' => 'czech-republic', 'tax' => 20],
        ];

        foreach ($items as $item) {
            Country::updateOrCreate(['code' => $item['code']], $item);
        }
    }

}