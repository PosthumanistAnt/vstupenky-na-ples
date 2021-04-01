<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;

class Home extends Component
{

    public function reserve()
    {
        return redirect()->route('seat-picker');
    }

    public function render()
    {
        return view('livewire.home', [
            'event' => Event::with('halls')->where('id', '1')->first()
        ])->layout('components.layouts.app');
    }        
}
