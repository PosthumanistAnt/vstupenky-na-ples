<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class Dashboard extends Component
{
    public function seatpicker()
    {
        redirect('seat-picker');
    }
    public function render()
    {
        return view('livewire.dashboard', [
            'orders' => Order::where('user_id', auth()->user()->id)->with(['state', 'orderItems.seat.seatType'])->get(),
        ])
        ->layout('components.layouts.app');
    }
}
