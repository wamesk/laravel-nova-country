<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // Export model
            $model = app_path('Models/Country.php');
            if (!file_exists($model)) {
                $this->createModel($model);
            }

            // Export Nova resource
            $this->publishes([__DIR__ . '/../app/Nova' => app_path('Nova')], ['nova', 'wame', 'country']);

            // Export policy
            $this->publishes([__DIR__ . '/../app/Policies' => app_path('Policies')], ['policy', 'wame', 'country']);

            // Export migration
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], ['migrations', 'wame', 'country']);

            // Export seeder
            $this->publishes([__DIR__ . '/../database/seeders' => database_path('seeders')], ['seeders', 'wame', 'country']);

            // Export lang
            $this->publishes([__DIR__ . '/../resources/lang' => resource_path('lang')], ['langs', 'wame', 'country']);
        }
    }


    private function createModel($model): void
    {
        $file = fopen($model, 'w');
        $idType = config('wame-commands.id-type');

        if ('ulid' === $idType) {
            $use = "use Illuminate\Database\Eloquent\Concerns\HasUlids;\n";
            $use2 = "    use HasUlids;\n";
        } elseif ('uuid' === $idType) {
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
