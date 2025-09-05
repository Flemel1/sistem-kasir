<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{

    public function logout(): void
    {
        Auth::logout();

        session()->invalidate();

        $this->redirectRoute('auth.login');
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
