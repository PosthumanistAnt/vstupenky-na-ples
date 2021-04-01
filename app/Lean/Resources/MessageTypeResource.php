<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Text;
use Lean\LeanResource;
use Lean\Fields\Pikaday;
use Lean\Fields\Relations\HasMany;

class MessageTypeResource extends LeanResource
{
    public static string $model = \App\Models\MessageType::class;

    public static array $searchable = [
        'id',
        'type',
    ];

    public static string $title = 'type';
    public static string $icon = 'heroicon-o-annotation';
    public static int $resultsPerPage = 10;

    public static array $lang = [
        // 'create.submit' => 'Create MessageType',
        // 'notifications.created' => 'MessageType created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),
            Text::make('type')->label(__('Type')),
            HasMany::make('messages')->of(MessageResource::class),

            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    } 

    public static function label(): string
    {
        return __('MessageType');
    }

    public static function pluralLabel(): string
    {
        return __('MessageTypes');
    }
}