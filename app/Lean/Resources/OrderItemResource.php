<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\LeanResource;
use Lean\Fields\Pikaday;
use Lean\Fields\Relations\BelongsTo;

class OrderItemResource extends LeanResource
{
    public static string $model = \App\Models\OrderItem::class;

    public static array $searchable = [
        'id',
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-ticket';
    public static int $resultsPerPage = 10;

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
        return __('ObjednávkaItem');
    }

    public static function pluralLabel(): string
    {
        return __('ObjednávkaItemy');
    }
}