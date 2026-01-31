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

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
            'price_choose' => 'required',
            'input_multiple_additional_products' => 'array',
            'input_single_additional_products' => 'array',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Jumlah wajib diisi',
            'amount.numeric' => 'Jumlah harus berupa angka',
            'amount.min' => 'Jumlah minimal 1',
            'price_choose.required' => 'Harga wajib diisi',
            'input_multiple_additional_products.array' => 'Item wajib diisi',
            'input_single_additional_products.array' => 'Item wajib diisi',
        ];
    }
}
