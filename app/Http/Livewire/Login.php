<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;
    public $credentials_error;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function login()
    {
        $this->validate();
        if(Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect('/seat-picker');
        } 
        $this->credentials_error = "Špatný email nebo heslo";
    }
    
    public function register()
    {
        return redirect('register');
    }

    public function render()
    {
        return view('livewire.login')
        ->layout('components.layouts.app');
    }
}

