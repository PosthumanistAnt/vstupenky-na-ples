<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Text;
use Lean\Fields\Relations\HasMany;
use Lean\LeanResource;

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