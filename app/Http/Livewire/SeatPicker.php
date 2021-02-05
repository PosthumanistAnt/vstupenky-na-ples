<?php

namespace App\Http\Livewire;

use App\Models\Seat;
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
            'seats' => Seat::all(),
        ]);
    }
}
