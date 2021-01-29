<?php

namespace App\Lean\Pages;

use Lean\Livewire\Pages\LeanPage;

class Welcome extends LeanPage
{
    public static function label(): string
    {
        return 'Home';
    }

    public static function icon(): string
    {
        return 'heroicon-o-home';
    }

    public function render()
    {
        return view('lean.pages.welcome');
    }
}
