<?php

namespace App\Http\Livewire;

use App\Models\Table;
use App\Models\Seat;
use Livewire\Component;
use Illuminate\Support\Collection;

class SeatPicker extends Component
{
    public $selectedSeats;
    public $totalPrice;

    public $listeners = ['seatAddedToSelection', 'selectedSeatsAddedToCart'];

    public function __construct()
    {
        $this->selectedSeats = new \Illuminate\Database\Eloquent\Collection;
        $this->totalPrice = 0; 
    }

    public function seatAddedToSelection($seatId)
    {
        $addedSeat = Seat::find($seatId);

        if(!$this->selectedSeats->contains($addedSeat)){
            $this->selectedSeats->push($addedSeat);
        }else{
            $this->selectedSeats = $this->selectedSeats->reject($addedSeat);
        }
        
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
