<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\Fields\Number;
use Lean\Fields\Relations\HasMany;
use Lean\LeanResource;

class HallResource extends LeanResource
{
    public static string $model = \App\Models\Hall::class;

    public static array $searchable = [
        'id',
        'location',
        'description',
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-office-building';
    public static int $resultsPerPage = 10;

    public static array $lang = [
        // 'create.submit' => 'Create Hall',
        // 'notifications.created' => 'Hall created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('location')->label(__('Name')),
            Number::make('table_columns')->label(__('Table columns')),
            Number::make('table_rows')->label(__('Table rows')),
            Text::make('description')->label(__('Description')),
            HasMany::make('tables')->of(TableResource::class)->label(__('Seats')),


            
        ];
    }

    public static function label(): string
    {
        return __('Hall');
    }

    public static function pluralLabel(): string
    {
        return __('Halls');
    }
}