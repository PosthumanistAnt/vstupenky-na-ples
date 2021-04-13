<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Text;
use Lean\LeanResource;
use Lean\Fields\Pikaday;
use Lean\Fields\Relations\BelongsTo;

class OrderResource extends LeanResource
{
    public static string $model = \App\Models\Order::class;

    public static array $searchable = [
        'id',
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-ticket';
    public static int $resultsPerPage = 10;

    public static array $lang = [
        // 'create.submit' => 'Create Order',
        // 'notifications.created' => 'Order created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            BelongsTo::make('user')->parent(UserResource::class)->label(__('User')),
            BelongsTo::make('state')->parent(OrderStateResource::class)->label(__('Order state')),
            
            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('Objednávka');
    }

    public static function pluralLabel(): string
    {
        return __('Objednávky');
    }
}