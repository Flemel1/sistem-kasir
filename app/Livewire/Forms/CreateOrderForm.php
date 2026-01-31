<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateOrderForm extends Form
{
    public ?string $customer_name;

    public ?string $cash_money;

    public string $status_order = 'closed';

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|regex:/^[a-zA-Z]+$/',
            'cash_money' => 'required|numeric',
            'status_order' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Nama wajib diisi',
            'customer_name.regex' => 'Nama harus berupa huruf',
            'cash_money.required' => 'Uang wajib diisi',
            'cash_money.numeric' => 'Uang harus berupa angka',
            'status_order.required' => 'Status wajib diisi',
        ];
    }
}
