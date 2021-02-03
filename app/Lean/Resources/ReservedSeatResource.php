<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\Fields\Relations\BelongsTo;
use Lean\LeanResource;

class ReservedSeatResource extends LeanResource
{
    public static string $model = \App\Models\ReservedSeat::class;

    public static array $searchable = [
        'id',
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-ticket';
    public static int $resultsPerPage;

    public static array $lang = [
        // 'create.submit' => 'Create ReservedSeat',
        // 'notifications.created' => 'ReservedSeat created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            BelongsTo::make('user_id')->parent(UserResource::class)->label(__('User')),
            BelongsTo::make('seat_id')->parent(SeatResource::class)->label(__('Seat')),
            
            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('ReservedSeat');
    }

    public static function pluralLabel(): string
    {
        return __('ReservedSeats');
    }
}