<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
    }

    public function register()
    {
        $this->validate();

        $newUser = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "password" => Hash::make($this->password)
        ]);

        Auth::login($newUser);

        event(new Registered($newUser));

        return redirect()->route('verification.notice');
    }
    public function login()
    {
        return redirect("login");
    }
    public function render()
    {
        return view('livewire.register')
        ->layout('components.layouts.app');
    }
}
