# Laravel Nova Country


## Requirements

- `laravel/nova: ^5.0`


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

## Usage

```php
Select::make(__('customer.field.country'), 'country_id')
    ->help(__('customer.field.country.help'))
    ->options(fn () => resolve(CountryService::class)->getListForSelect())
    ->searchable()
    ->required()
    ->rules('required')
    ->onlyOnForms(),
                        
BelongsTo::make(__('customer.field.country'), 'country', Country::class)
    ->displayUsing(fn () => resolve(CountryService::class)->displayUsing($request, $this))
    ->sortable()
    ->filterable()
    ->showOnPreview()
    ->exceptOnForms(),
```
