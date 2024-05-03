# Laravel Nova 4 Country



## Requirements

- `laravel/nova: ^4.0`


## Installation

```bash
composer require wamesk/laravel-nova-country
```

```bash
php artisan migrate
```

```bash
php artisan db:seed --class=LanguageSeeder

php artisan db:seed --class=CurrencySeeder

php artisan db:seed --class=CountrySeeder
```

Add Policy to `./app/Providers/AuthServiceProvider.php`

```php
protected $policies = [
    'App\Models\Country' => 'Policies\CountryPolicy',
];
```

## Usage

```php
Select::make(__('customer.field.country'), 'country_code')
    ->help(__('customer.field.country.help'))
    ->options(fn () => CountryController::getListForSelect())
    ->searchable()
    ->required()
    ->rules('required')
    ->onlyOnForms(),
                        
BelongsTo::make(__('customer.field.country'), 'country', Country::class)
    ->displayUsing(fn () => CountryController::displayUsing($request, $this))
    ->sortable()
    ->filterable()
    ->showOnPreview()
    ->exceptOnForms(),
```
