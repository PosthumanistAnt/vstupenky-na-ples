<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Text;
use Lean\Fields\Number;
use Lean\Fields\Pikaday;
use Lean\Fields\Relations\BelongsTo;
use Lean\LeanResource;

class SeatResource extends LeanResource
{
    public static string $model = \App\Models\Seat::class;

    public static array $searchable = [
        'id',
        'number',
        'description',
    ];

    public static string $title = 'number';
    public static string $icon = 'heroicon-o-ticket';
    public static int $resultsPerPage = 10;

    public static array $lang = [
        // 'create.submit' => 'Create Seat',
        // 'notifications.created' => 'Seat created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('description')->optional()->label(__('Description')),
            Number::make('number')->label(__('Number')),
            BelongsTo::make('table')->parent(TableResource::class)->label(__('Table')),
            BelongsTo::make('seatType')->parent(SeatTypeResource::class)->label(__('Seat type')),
            
            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('Vstupenka');
    }

    public static function pluralLabel(): string
    {
        return __('Vstupenky');
    }
}