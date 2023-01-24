<?php

namespace Wame\LaravelNovaCountry;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Export model
            $model = app_path('Models/Country.php');
            if (!file_exists($model)) $this->createModel($model);

            // Export Nova resource
            $this->publishes([__DIR__ . '/../app/Nova/Country.php' => app_path('Nova/Country.php')], ['nova', 'wame', 'country']);

            // Export policy
            $this->publishes([__DIR__ . '/../app/Policies/CountryPolicy.php' => app_path('Policies/CountryPolicy.php')], ['policy', 'wame', 'country']);

            // Export migration
            $this->publishes([__DIR__ . '/../database/migrations/2023_01_24_154805_create_countries_table.php' => database_path('migrations/2023_01_24_154805_create_countries_table.php')], ['migrations', 'wame', 'country']);

            // Export seeder
            $this->publishes([__DIR__ . '/../database/seeders/CountrySeeder.php' => database_path('seeders/CountrySeeder.php')], ['seeders', 'wame', 'country']);

            // Export lang
            $this->publishes([__DIR__ . '/../resources/lang/sk/country.php' => resource_path('lang/sk/country.php')], ['langs', 'wame', 'country']);
        }
    }


    private function createModel($model)
    {
        $file = fopen($model, "w");
        $idType = config('wame-commands.id-type');

        if ($idType === 'ulid') {
            $use = "use Illuminate\Database\Eloquent\Concerns\HasUlids;\n";
            $use2 = "    use HasUlids;\n";
        } elseif ($idType === 'uuid') {
            $use = "use Illuminate\Database\Eloquent\Concerns\HasUuids;\n";
            $use2 = "    use HasUuids;\n";
        } else {
            $use = '';
            $use2 = '';
        }

        $lines = [
            "<?php \n",
            "\n",
            "namespace App\Models;\n",
            "\n",
            $use,
            "\n",
            "class Country extends \Wame\LaravelNovaCountry\Models\Country\n",
            "{\n",
            $use2,
            "\n",
            "}\n",
            "\n",
        ];

        fwrite($file, implode('', $lines));
        fclose($file);
    }

}
