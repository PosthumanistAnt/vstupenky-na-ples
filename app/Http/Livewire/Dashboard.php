<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class Dashboard extends Component
{
    public $verificationExpireTime;

    public function __construct()
    {
        $this->verificationExpireTime = Config::get('order.verification_expire_time');
    }

    public function seatpicker()
    {
        redirect('seat-picker');
    }
    public function render()
    {
        return view('livewire.dashboard', [
            'orders' => Order::where('user_id', auth()->user()->id)->with(['state', 'orderItems.seat.seatType'])->get(),
            'verification_expire_time' => $this->verificationExpireTime,
        ])
        ->layout('components.layouts.app');
    }
}
