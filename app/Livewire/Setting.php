<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Setting extends Component
{
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak sama',
        ];
    }

    public function update_password()
    {
        $this->validate();

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama tidak sesuai',
            ]);
        }

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset();

        $this->dispatch('password-updated', [
            'type' => 'success',
            'message' => 'Password berhasil diperbarui'
        ]);
    }

    public function render()
    {
        return view('livewire.setting');
    }
}
