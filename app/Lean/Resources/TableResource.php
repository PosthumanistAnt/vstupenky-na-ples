<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Text;
use Lean\LeanResource;
use Lean\Fields\Number;
use Lean\Fields\Pikaday;
use Lean\Fields\Relations\HasMany;
use Lean\Fields\Relations\BelongsTo;

class TableResource extends LeanResource
{
    public static string $model = \App\Models\Table::class;

    public static array $searchable = [
        'id',
        'description',
        'position_x',
        'position_y',
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-view-grid';
    public static int $resultsPerPage = 10;

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
            Number::make('position_x')->label(__('Position X')),
            Number::make('position_y')->label(__('Position Y')),
            BelongsTo::make('hall')->parent(HallResource::class)->label(__('Hall')),
            HasMany::make('seats')->of(SeatResource::class)->label(__('Seats')),

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