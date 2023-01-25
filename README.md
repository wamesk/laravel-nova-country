# Laravel Nova 4 Country



## Requirements

- `laravel/nova: ^4.0`


## Installation

```bash
composer require wamesk/laravel-nova-country
```

```bash
php artisan vendor:publish
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
    'App\Models\Country' => 'App\Policies\CountryPolicy',
];
```

## Usage

```php
BelongsTo::make(__('customer.field.country'), 'country', Country::class)
    ->help(__('customer.field.country.help'))
    ->withoutTrashed()
```
