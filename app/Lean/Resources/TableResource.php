<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\Fields\Number;
use Lean\Fields\Relations\BelongsTo;
use Lean\LeanResource;

class TableResource extends LeanResource
{
    public static string $model = \App\Models\Table::class;

    public static array $searchable = [
        'id',
        'description',
        'num_seats',
        'hall_column',
        'hall_row',
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-view-grid';
    public static int $resultsPerPage;

    public static array $lang = [
        // 'create.submit' => 'Create Table',
        // 'notifications.created' => 'Table created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),
            Text::make('description')->label(__('Description')),
            Number::make('num_seats')->label(__('Number of seats')),
            Number::make('hall_column')->label(__('Hall column')),
            Number::make('hall_row')->label(__('Hall row')),
            BelongsTo::make('hall')->parent(HallResource::class)->label(__('Hall')),
            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('Table');
    }

    public static function pluralLabel(): string
    {
        return __('Tables');
    }
}