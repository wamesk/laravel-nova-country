<?php

declare(strict_types = 1);

namespace App\Nova;

use ShuvroRoy\NovaTabs\Tab;
use ShuvroRoy\NovaTabs\Tabs;
use ShuvroRoy\NovaTabs\Traits\HasTabs;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Country extends BaseResource
{
    use HasTabs;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Country::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = ['code', ' - ', 'title'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'code', 'title',
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
            Tabs::make(__('country.detail', ['title' => $this->title ?: '']), [
                Tab::make(__('country.singular'), [
                    ID::make()->onlyOnForms(),

                    Text::make(__('country.field.title'), 'title')
                        ->help(__('country.field.title.help'))
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview(),

                    Text::make(__('country.field.code'), 'code')
                        ->help(__('country.field.code.help'))
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview(),

                    BelongsTo::make(__('country.field.currency'), 'currency', Currency::class)
                        ->help(__('country.field.currency.help'))
                        ->withSubtitles()
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview(),

                    BelongsTo::make(__('country.field.language'), 'language', Language::class)
                        ->help(__('country.field.language.help'))
                        ->withSubtitles()
                        ->showCreateRelationButton()
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview(),

                    Boolean::make(__('country.field.status'), 'status')
                        ->help(__('country.field.status.help'))
                        ->default(\App\Models\Country::STATUS_ENABLED)
                        ->sortable()
                        ->filterable()
                        ->showOnPreview(),
                ]),

                HasMany::make(__('vat_rate.plural'), 'vatRates', VatRate::class),
            ])->withToolbar(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
