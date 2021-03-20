<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\LeanResource;

class SettingResource extends LeanResource
{
    public static string $model = \App\Models\Setting::class;

    public static array $searchable = [
        'setting',
        'value',
    ];

    public static string $title = 'setting';
    public static string $icon = 'heroicon-o-document';
    public static int $resultsPerPage;

    public static array $lang = [
        // 'create.submit' => 'Create Setting',
        // 'notifications.created' => 'Setting created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('setting')->label(__('setting')),
            Text::make('value')->label(__('value')),
        ];
    }

    public static function label(): string
    {
        return __('Setting');
    }

    public static function pluralLabel(): string
    {
        return __('Settings');
    }
}