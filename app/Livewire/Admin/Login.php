<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\LoginForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.blank')]
class Login extends Component
{
    public LoginForm $form;

    public function mount()
    {
        if (Auth::check()) {
            $this->redirectRoute('dashboard');
        }
    }

    public function login(Request $request): void
    {
        $isLogged = $this->form->login();

        if ($isLogged) {
            session()->regenerate();

            $this->redirectRoute('dashboard');
        }

        session()->flash('auth.error', 'username atau password anda salah');
    }

    public function render()
    {
        return view('livewire.admin.login');
    }
}
