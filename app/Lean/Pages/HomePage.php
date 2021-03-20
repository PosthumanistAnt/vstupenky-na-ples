<?php

namespace App\Lean\Pages;

use Lean\Livewire\Pages\LeanPage;

class HomePage extends LeanPage
{
    public static function label(): string
    {
        return __('Home');
    }

    public static function icon(): string
    {
        return 'heroicon-o-home';
    }

    // Any custom Livewire logic...

    public function render()
    {
        return view('lean.pages.home');
    }
}