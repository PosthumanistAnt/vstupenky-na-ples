<?php

namespace App\Lean\Resources;

use Lean\Fields\ID;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\Fields\Number;
use Lean\Fields\Relations\HasMany;
use Lean\LeanResource;

class SeatTypeResource extends LeanResource
{
    public static string $model = \App\Models\SeatType::class;

    public static array $searchable = [
        'id',
        'type',
        'description',
        'price',
    ];

    public static string $title = 'id';
    public static string $icon = 'heroicon-o-ticket';
    public static int $resultsPerPage = 10;

    public static array $lang = [
        // 'create.submit' => 'Create SeatType',
        // 'notifications.created' => 'SeatType created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('type')->label(__('Type')),
            Text::make('description')->label(__('Description')),
            Number::make('price')->label(__('Price')),
            HasMany::make('seats')->of(SeatResource::class)->label(__('Seats')),
        ];
    }

    public static function label(): string
    {
        return __('SeatType');
    }

    public static function pluralLabel(): string
    {
        return __('SeatTypes');
    }
}