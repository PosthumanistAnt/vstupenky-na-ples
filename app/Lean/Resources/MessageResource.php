<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Text;
use Lean\LeanResource;
use Lean\Fields\Pikaday;

class MessageResource extends LeanResource
{
    public static string $model = \App\Models\Message::class;

    public static array $searchable = [
        'id',
        'title',
    ];

    public static string $title = 'title';
    public static string $icon = 'heroicon-o-annotation';
    public static int $resultsPerPage = 10;

    public static array $lang = [
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('title')->label(__('Title')),
            Text::make('message')->label(__('Message')),

            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('Zpráva');
    }

    public static function pluralLabel(): string
    {
        return __('Zprávy');
    }
}