<?php

namespace App\Http\Livewire;

use App\Models\Order as ModelsOrder;
use Livewire\Component;

class Order extends Component
{
    public $order;

    public function mount($id)
    {
        $this->order = ModelsOrder::with('orderItems.seat.seatType')->find($id);
    }

    public function render()
    {
        return view('livewire.order')
        ->layout('components.layouts.app');
    }
}
