<?php

namespace App\Http\Livewire;

use App\Models\Seat;
use App\Models\Table;
use App\Models\Order;
use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;
use App\Models\SeatType;
use Illuminate\Support\Facades\Config;

class SeatPicker extends Component
{
    public $selectedSeats;
    public $totalPrice;
    public $verificationExpireTime;

    public $listeners = ['seatSelected', 'seatDeselected'];

    public function __construct()
    {
        $this->selectedSeats = new \Illuminate\Database\Eloquent\Collection;
        $this->totalPrice = 0; 
        $this->verificationExpireTime = Config::get('order.verification_expire_time');
    }

    public function seatSelected($seatId)
    {

        $addedSeat = Seat::with('orderItem.order.state')->find($seatId);

        $order = $addedSeat->orderItem->order ?? null;
        
        if(!is_null($order))
        {
            $state = $order->state->id ?? 0;

            if($state === 2)
            {
                return false;
            }
            
            if($state === 1 && $order->created_at->addMinutes($this->verificationExpireTime)->isFuture())
            {
                return false;
            }
        }

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
        $now = now()->toDateTimeString();
        $cart = $this->selectedSeats;
        $user = auth()->user();
        $hash = sha1($user->email);

        if($cart->isEmpty())
        {
            session()->flash('cart_empty', 'Košík je prázdný.');
            return false;
        }

	foreach($cart->all() as $selectedSeat) {
	    if(($selectedSeat->orderItem->order->state->id ?? 0) === 1 && $selectedSeat->orderItem->order->created_at->addMinutes($this->verificationExpireTime)->isFuture()) {
	        session()->flash('cart_empty', 'Vyskytla se chyba, vstupenku kterou jste si vybrali si již pravděpodobně někdo objednal');
		return false;
	    }
	}

        $order_id = (DB::transaction(function() use($cart, $now, $user) {
            $order = new Order;
            $order->user_id = $user->id;
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
            return($order->id);
        }));

        Mail::to($user->email)->send(new ReservationConfirmation($order_id, $hash));
        session()->flash('order_placed', 'Objednávka uložena. Potvrďte ji v emailu.');
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
            'tables' => Table::with(['seats.seatType', 'seats.orderItem'])->get(),
            'seatTypes' => SeatType::all(),
            'verification_expire_time' => $this->verificationExpireTime,
        ])
        ->layout('components.layouts.app');
    }
}
