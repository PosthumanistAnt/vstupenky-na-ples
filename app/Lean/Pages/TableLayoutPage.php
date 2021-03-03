<?php

namespace App\Lean\Pages;

use App\Models\Table;
use Lean\Livewire\Pages\LeanPage;

class TableLayoutPage extends LeanPage
{
    public static function label(): string
    {
        return __('TableLayout');
    }

    public static function icon(): string
    {
        return 'heroicon-o-home';
    }

    // Any custom Livewire logic...

    public function render()
    {
        return view('lean.pages.tableLayout', [
            'tables' => Table::with('seats.seatType')->get()
        ]);
    }
}