<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\Fields\Relations\BelongsTo;
use Lean\LeanResource;

class OrderStateResource extends LeanResource
{
    public static string $model = \App\Models\OrderState::class;

    public static array $searchable = [
        'id',
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-ticket';
    public static int $resultsPerPage;

    public static array $lang = [
        // 'create.submit' => 'Create OrderState',
        // 'notifications.created' => 'OrderState created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('state')->label(__('State')),

            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('OrderState');
    }

    public static function pluralLabel(): string
    {
        return __('OrderStates');
    }
}