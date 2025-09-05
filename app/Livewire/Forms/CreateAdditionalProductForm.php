<?php

namespace App\Livewire\Forms;

use App\Models\AdditionalProduct;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateAdditionalProductForm extends Form
{
    #[Validate(rule: 'required|string|max:100')]
    public ?string $group_name;

    #[Validate(rule: [
        'items' => 'required|array|min:1',
        'items.*.item_name' => 'required|string|max:100',
        'items.*.item_price' => 'required|numeric'
    ])]
    public array $items = [[]];

    #[Validate(rule: 'required')]
    public bool $is_multiple = false;

    #[Validate(rule: 'required')]
    public bool $is_optional = false;

    public function store(): bool
    {
        $this->validate();
        $additional_products = AdditionalProduct::create([
            'group_name' => $this->group_name,
            'items' => $this->items,
            'is_multiple' => $this->is_multiple,
            'is_optional' => $this->is_optional
        ]);

        if ($additional_products) {
            return true;
        }

        return false;
    }
}
