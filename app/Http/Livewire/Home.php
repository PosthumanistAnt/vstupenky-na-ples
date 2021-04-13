<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Message;

class Home extends Component
{

    public function reserve()
    {
        return redirect()->route('seat-picker');
    }

    public function render()
    {
        return view('livewire.home', [
            'event' => Event::with('halls')->where('id', '1')->first(),
            'messages' => Message::all(),
        ])->layout('components.layouts.app');
    }        
}
