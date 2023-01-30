<?php

declare(strict_types = 1);

namespace App\Nova;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Country extends BaseResource
{
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
        'id', 'code', 'iso', 'title',
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
                        ->rules('required')
                        ->showOnPreview(),

                    Slug::make(__('country.field.slug'), 'slug')
                        ->from('title')
                        ->help(__('country.field.slug.help'))
                        ->rules('required')
                        ->onlyOnForms(),

                    Text::make(__('country.field.code'), 'code')
                        ->help(__('country.field.code.help'))
                        ->sortable()
                        ->filterable()
                        ->rules('required')
                        ->showOnPreview(),

                    Text::make(__('country.field.iso'), 'iso')
                        ->help(__('country.field.iso.help'))
                        ->showOnPreview()
                        ->hideFromIndex(),

                    Text::make(__('country.field.iso_numeric'), 'iso_numeric')
                        ->help(__('country.field.iso_numeric.help'))
                        ->showOnPreview()
                        ->hideFromIndex(),

                    Number::make(__('country.field.tax'), 'tax')
                        ->help(__('country.field.tax.help'))
                        ->min(0)
                        ->max(100)
                        ->default(20)
                        ->displayUsing(fn () => $this->tax . ' %')
                        ->rules('required')
                        ->showOnPreview(),

                    BelongsTo::make(__('country.field.currency'), 'currency', Currency::class)
                        ->help(__('country.field.currency.help'))
                        ->withSubtitles()
                        ->sortable()
                        ->filterable()
                        ->rules('required')
                        ->showOnPreview(),

                    BelongsTo::make(__('country.field.language'), 'language', Language::class)
                        ->help(__('country.field.language.help'))
                        ->withSubtitles()
                        ->showCreateRelationButton()
                        ->sortable()
                        ->filterable()
                        ->rules('required')
                        ->showOnPreview(),

                    Boolean::make(__('country.field.status'), 'status')
                        ->help(__('country.field.status.help'))
                        ->default(\App\Models\Country::STATUS_ENABLED)
                        ->sortable()
                        ->filterable()
                        ->showOnPreview(),
                ]),
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
