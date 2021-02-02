<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\LeanResource;

class HallResource extends LeanResource
{
    public static string $model = \App\Models\Hall::class;

    public static array $searchable = [
        'id',
        'name',
    ];

    public static string $title = 'name';
    public static string $icon = 'heroicon-o-document';
    public static int $resultsPerPage;

    public static array $lang = [
        // 'create.submit' => 'Create Hall',
        // 'notifications.created' => 'Hall created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('name')->label(__('Name')),

            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('Hall');
    }

    public static function pluralLabel(): string
    {
        return __('Halls');
    }
}