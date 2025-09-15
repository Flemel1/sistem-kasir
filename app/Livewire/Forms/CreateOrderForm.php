<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateOrderForm extends Form
{
    #[Validate(rule: 'required|string|regex:/^[a-zA-Z]+$/')]
    public ?string $customer_name;
    #[Validate(rule: 'required|numeric')]
    public ?string $cash_money;
    #[Validate(rule: 'required|string')]
    public string $status_order = 'closed';
}
