<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\Fields\Relations\BelongsTo;
use Lean\LeanResource;

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
        // 'create.submit' => 'Create Message',
        // 'notifications.created' => 'Message created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('title')->label(__('Title')),
            Text::make('message')->label(__('Message')),
            BelongsTo::make('messageType')->parent(MessageTypeResource::class)->label(__('Message type')),

            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('Message');
    }

    public static function pluralLabel(): string
    {
        return __('Messages');
    }
}