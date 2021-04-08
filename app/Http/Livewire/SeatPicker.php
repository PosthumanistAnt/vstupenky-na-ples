<?php

namespace App\Http\Livewire;

use App\Models\Seat;
use App\Models\Table;
use App\Models\Order;
use Livewire\Component;
use App\Models\OrderItem;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    
    public function unsetMessage($message)
    {
        session()->forget($message);
    }

    public function sortSelectedSeats()
    {
        $this->selectedSeats = $this->selectedSeats->sortBy('number');
    }

    public function orderSeats()
    {
        $cart = $this->selectedSeats;

        if($cart->isEmpty())
        {
            session()->flash('cart_empty', 'Košík je prázdný.');
            return false;
            dd('nothing in cart TODO modal?');
        }

        DB::transaction(function() use($cart) {
            $now = now()->toDateTimeString();
            
            $order = new Order;
            $order->code = 'neni';
            $order->user_id = auth()->user()->id;
            $order->state_id = 1;
            $order->save();
        
            $orderItems = [];
            foreach ($cart->all() as $selectedSeat) {
                $orderItems[] = [
                    'order_id' => $order->id,
                    'seat_id' => $selectedSeat->id,
                    'created_at'=> $now,
                    'updated_at'=> $now,
                ];
            }

            OrderItem::insert($orderItems);
        });

        $this->selectedSeats = new \Illuminate\Database\Eloquent\Collection;
        $this->refreshCartPrice();
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
