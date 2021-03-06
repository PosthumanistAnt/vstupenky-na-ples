<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Text;
use Lean\LeanResource;
use Lean\Fields\Pikaday;

class OrderStateResource extends LeanResource
{
    public static string $model = \App\Models\OrderState::class;

    public static array $searchable = [
        'id',
    ];

    public static string $title = 'state';
    public static string $icon = 'heroicon-o-ticket';
    public static int $resultsPerPage = 10;

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
        return __('ObjednávkaStatus');
    }

    public static function pluralLabel(): string
    {
        return __('ObjednávkaStatusy');
    }
}