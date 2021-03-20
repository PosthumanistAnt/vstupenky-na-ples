<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\Fields\Relations\BelongsTo;
use Lean\LeanResource;

class SeatResource extends LeanResource
{
    public static string $model = \App\Models\Seat::class;

    public static array $searchable = [
        'id',
        'description',
    ];

    public static string $title = 'name';
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

            Text::make('description')->label(__('Description')),
            BelongsTo::make('table')->parent(TableResource::class)->label(__('Table')),
            BelongsTo::make('seatType')->parent(SeatTypeResource::class)->label(__('Seat type')),
            
        ];
    }

    public static function label(): string
    {
        return __('Seat');
    }

    public static function pluralLabel(): string
    {
        return __('Seats');
    }
}