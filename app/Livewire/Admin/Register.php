<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\RegisterForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.blank')]
class Register extends Component
{
    public RegisterForm $form;

    public function mount()
    {
        if (Auth::check()) {
            $this->redirectRoute('dashboard');
        }
    }

    public function register(): void
    {
        $isSuccess = $this->form->register();

        if ($isSuccess) {
            $this->form->reset();
            $this->redirectRoute('auth.login');
        }

        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.admin.register');
    }
}
