<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Nova;

use App\Nova\Resource;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use ShuvroRoy\NovaTabs\Tab;
use ShuvroRoy\NovaTabs\Tabs;
use ShuvroRoy\NovaTabs\Traits\HasTabs;
use Wame\LaravelNovaCountry\Enums\CountryStatusEnum;
use Wame\LaravelNovaCurrency\Nova\Currency;
use Wame\LaravelNovaLanguage\Nova\Language;

class Country extends Resource
{
    use HasTabs;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \Wame\LaravelNovaCountry\Models\Country::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Tabs::make(__('laravel-nova-country::country.detail', ['title' => $this->title ?: '']), [
                Tab::make(__('laravel-nova-country::country.singular'), [
                    ID::make()
                        ->sortable()
                        ->rules('required')
                        ->readonly()
                        ->showOnPreview(),

                    Text::make(__('laravel-nova-country::country.field.title'), 'title')
                        ->help(__('laravel-nova-country::country.field.title.help'))
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview(),

                    BelongsTo::make(__('laravel-nova-country::country.field.currency'), 'currency', Currency::class)
                        ->help(__('laravel-nova-country::country.field.currency.help'))
                        ->withSubtitles()
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview(),

                    BelongsTo::make(__('laravel-nova-country::country.field.language'), 'language', Language::class)
                        ->help(__('laravel-nova-country::country.field.language.help'))
                        ->withSubtitles()
                        ->showCreateRelationButton()
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->withoutTrashed()
                        ->rules('required')
                        ->showOnPreview(),

                    Boolean::make(__('laravel-nova-country::country.field.status'), 'status')
                        ->help(__('laravel-nova-country::country.field.status.help'))
                        ->default(CountryStatusEnum::ENABLED->value)
                        ->sortable()
                        ->filterable()
                        ->showOnPreview(),
                ]),

                //HasMany::make(__('laravel-nova-country::vat_rate.plural'), 'vatRates', VatRate::class),
            ])->withToolbar(),
        ];
    }

    public static function label(): string
    {
        return __('laravel-nova-country::country.label');
    }

    public static function createButtonLabel(): string
    {
        return __('laravel-nova-country::country.create.button');
    }

    public static function updateButtonLabel(): string
    {
        return __('laravel-nova-country::country.update.button');
    }
}
