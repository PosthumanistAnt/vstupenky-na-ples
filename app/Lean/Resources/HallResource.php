<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Text;
use Lean\LeanResource;
use Lean\Fields\Pikaday;
use Lean\Fields\Relations\HasMany;
use Lean\Fields\Relations\BelongsTo;

class HallResource extends LeanResource
{
    public static string $model = \App\Models\Hall::class;

    public static array $searchable = [
        'id',
        'location',
        'description',
    ];

    public static string $title = 'location';
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

            Text::make('location')->label(__('Location')),
            Text::make('description')->optional()->label(__('Description')),
            BelongsTo::make('event')->parent(EventResource::class)->label(__('Event')),
            HasMany::make('tables')->of(TableResource::class)->label(__('Tables')),

            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('Hala');
    }

    public static function pluralLabel(): string
    {
        return __('Haly');
    }
}