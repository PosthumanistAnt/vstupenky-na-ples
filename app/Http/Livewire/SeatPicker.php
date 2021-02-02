<?php

namespace App\Http\Livewire;

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
        return view('livewire.seat-picker');
    }
}
