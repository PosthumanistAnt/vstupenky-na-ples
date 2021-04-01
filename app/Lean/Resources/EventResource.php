<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\Fields\Relations\HasMany;
use Lean\LeanResource;

class EventResource extends LeanResource
{
    public static string $model = \App\Models\Event::class;

    public static array $searchable = [
        'id', 'reservation_start', 'reservation_end', 'ball_start', 'location', 'description'
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-document';
    public static int $resultsPerPage = 30;

    public static array $lang = [
        // 'create.submit' => 'Create Event',
        // 'notifications.created' => 'Event created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Pikaday::make('reservation_start'),
            Pikaday::make('reservation_end'),
            Text::make('ball_start'),
            Text::make('description'),
            Text::make('location'),
            HasMany::make('halls')->of(HallResource::class)->label(__('Halls')),

            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('Event');
    }

    public static function pluralLabel(): string
    {
        return __('Events');
    }
}