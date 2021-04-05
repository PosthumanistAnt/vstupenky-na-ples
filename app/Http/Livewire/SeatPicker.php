<?php

namespace App\Http\Livewire;

use App\Models\Table;
use App\Models\Seat;
use Livewire\Component;

class SeatPicker extends Component
{
    public $selectedSeats = [];
    public $listeners = ['seatAddedToSelection', 'selectedSeatsAddedToCart'];

    public function seatAddedToSelection($seatId)
    {
        array_push($this->selectedSeats, $seatId);
    }   

    public function selectedSeatsAddedToCart()
    {
        dd($this->selectedSeats);
    }

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
