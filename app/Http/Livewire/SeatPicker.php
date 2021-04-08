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

    public $listeners = ['seatSelected', 'seatDeselected'];

    public function __construct()
    {
        $this->selectedSeats = new \Illuminate\Database\Eloquent\Collection;
        $this->totalPrice = 0; 
    }

    public function seatSelected($seatId)
    {
        $addedSeat = Seat::find($seatId);

        if(!$this->selectedSeats->contains($addedSeat)){
            $this->selectedSeats->push($addedSeat);
        }

        $this->sortSelectedSeats();
        $this->refreshCartPrice();
    }   

    public function seatDeselected($seatId)
    {
        $addedSeat = Seat::find($seatId);
        
        if($this->selectedSeats->contains($addedSeat)){
            $this->selectedSeats = $this->selectedSeats->except($addedSeat->id);
        }

        $this->sortSelectedSeats();
        $this->refreshCartPrice();
    }

    public function refreshCartPrice()
    {
        $this->totalPrice = $this->selectedSeats->sum('seatType.price');
    }

    public function sortSelectedSeats()
    {
        $this->selectedSeats = $this->selectedSeats->sortBy('number');
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
