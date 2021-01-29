<?php

namespace App\Lean\Resources;

use Lean\Fields\Email;
use Lean\Fields\ID;
use Lean\Fields\Password;
use Lean\Fields\Pikaday;
use Lean\Fields\Text;
use Lean\LeanResource;

class UserResource extends LeanResource
{
    public static string $model = \App\Models\User::class;

    public static array $searchable = [
        'id',
        'name',
        'email',
    ];

    public static string $title = 'name';
    public static string $icon = 'heroicon-o-user';
    public static int $resultsPerPage = 20;

    public static array $lang = [
        // 'create.submit' => 'Create User',
        // 'notifications.created' => 'User created!',
        // ...
    ];

    public static function fields(): array
    {
        return [
            ID::make('id'),

            Text::make('name')->label(__('Name')),
            Email::make('email')->label(__('Email')),
            Password::make('password')->label(__('Password'))->confirmed(),

            Pikaday::make('updated_at')->display('show', 'edit'),
            Pikaday::make('created_at')->disabled()->display('show'),
        ];
    }

    public static function label(): string
    {
        return __('User');
    }

    public static function pluralLabel(): string
    {
        return __('Users');
    }
}
