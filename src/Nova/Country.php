<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Nova;

use App\Nova\Resource;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tabs\Tab;
use Wame\LaravelNovaCountry\Enums\CountryStatusEnum;
use Wame\LaravelNovaCurrency\Nova\Currency;
use Wame\LaravelNovaLanguage\Nova\Language;
use Wame\LaravelNovaVatRate\Nova\VatRate;

class Country extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \Wame\LaravelNovaCountry\Models\Country::class;

    public function title(): string
    {
        return $this->title;
    }

    public static function searchableColumns(): array
    {
        return [
            'id',
            'title',
        ];
    }

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        if ($request->viaRelationship) {
            return self::relatableQuery($request, $query);
        }
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderByDesc('status')->orderBy('id');
        }

        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Tab::group(null, [
                Tab::make(__('laravel-nova-country::country.singular'), [
                    ID::make()
                        ->sortable()
                        ->rules('required')
                        ->readonly()
                        ->showOnPreview()
                        ->showWhenPeeking(),

                    Text::make(__('laravel-nova-country::country.field.title'), 'title')
                        ->help(__('laravel-nova-country::country.field.title.help'))
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview()
                        ->showWhenPeeking(),

                    BelongsTo::make(__('laravel-nova-country::country.field.currency'), 'currency', Currency::class)
                        ->help(__('laravel-nova-country::country.field.currency.help'))
                        ->withSubtitles()
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview()
                        ->showWhenPeeking(),

                    BelongsTo::make(__('laravel-nova-country::country.field.language'), 'language', Language::class)
                        ->help(__('laravel-nova-country::country.field.language.help'))
                        ->withSubtitles()
                        ->showCreateRelationButton()
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->withoutTrashed()
                        ->rules('required')
                        ->showOnPreview()
                        ->showWhenPeeking(),

                    Boolean::make(__('laravel-nova-country::country.field.status'), 'status')
                        ->help(__('laravel-nova-country::country.field.status.help'))
                        ->default(CountryStatusEnum::ENABLED->value)
                        ->sortable()
                        ->filterable()
                        ->showOnPreview()
                        ->showWhenPeeking(),
                ]),

                HasMany::make(__('laravel-nova-vat-rate::vat_rate.plural'), 'vatRates', VatRate::class),
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
