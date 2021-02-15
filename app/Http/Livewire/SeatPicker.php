<?php

namespace App\Http\Livewire;

use App\Models\Table;
use Livewire\Component;

class SeatPicker extends Component
{

    public function admin()
    {
        return redirect('admin');
    }

    public function logout()
    {
        return redirect('logout');
    }
    public function render()
    {
        return view('livewire.seat-picker', [
            'tables' => Table::with('seats.seatType')->get()
        ])
        ->layout('components.layouts.app');
    }
}
