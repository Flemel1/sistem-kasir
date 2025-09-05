<?php

namespace App\Livewire\Forms;

use App\Enums\PriceChoose;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddProductOrderForm extends Form
{
    #[Validate(rule: 'required|numeric|min:1')]
    public $amount = 1;

    #[Validate(rule: 'required')]
    public $price_choose = PriceChoose::NORMAL;

    #[Validate(rule: 'array')]
    public array $input_multiple_additional_products = [];

    #[Validate(rule: 'array')]
    public array $input_single_additional_products = [];
}
