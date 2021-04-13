<?php

namespace App\Lean\Pages;

use App\Models\Table;
use Lean\Livewire\Pages\LeanPage;

class TableLayoutPage extends LeanPage
{
    public $listeners = ['tablePositionUpdated'];

    public function tablePositionUpdated( $updatedTableAttributes )
    {
        $movedTable = Table::find( $updatedTableAttributes["id"] );
    
        $movedTable->fill([
            'position_x' => $updatedTableAttributes["x"],
            'position_y' => $updatedTableAttributes["y"],
        ]);
        
        $movedTable->save();

        session()->flash('message', 'změna pozice - ' . $updatedTableAttributes["id"] . ' ' . $updatedTableAttributes["x"] . ' ' . $updatedTableAttributes["y"]);
    }

    public static function label(): string
    {
        return __('Pozice stolů');
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