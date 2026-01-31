<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegisterForm extends Form
{
    public string $name;

    public string $username;

    public string $email;

    public string $password;

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'username' => 'required|string|min:3|max:100|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'name.min' => 'Nama minimal 3 karakter',
            'name.max' => 'Nama maksimal 100 karakter',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.max' => 'Username maksimal 100 karakter',
            'username.unique' => 'Username sudah ada',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Input harus berupa email',
            'email.unique' => 'Email sudah ada',
            'password.required' => 'Password wajib diisi',
        ];
    }

    public function register(): bool
    {
        $this->validate();
        DB::beginTransaction();
        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password
        ]);

        if ($user) {
            DB::commit();
            return true;
        }
        DB::rollBack();
        return false;
    }
}
