<?php

namespace App\Livewire\Forms;

use App\Models\AdditionalProduct;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateAdditionalProductForm extends Form
{
    public ?string $group_name;

    public array $items = [[]];

    public bool $is_multiple = false;

    public bool $is_optional = false;

    public function rules(): array
    {
        return [
            'group_name' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:100',
            'items.*.item_price' => 'required|numeric',
            'is_multiple' => 'required',
            'is_optional' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'group_name.required' => 'Nama wajib diisi',
            'group_name.max' => 'Nama maksimal 100 karakter',
            'items.required' => 'Item wajib diisi',
            'items.*.item_name.required' => 'Nama wajib diisi',
            'items.*.item_name.max' => 'Nama maksimal 100 karakter',
            'items.*.item_price.required' => 'Harga wajib diisi',
            'items.*.item_price.numeric' => 'Harga harus berupa angka',
            'is_multiple.required' => 'Status wajib diisi',
            'is_optional.required' => 'Status wajib diisi',
        ];
    }


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

    public function setGroup(AdditionalProduct $group): void
    {
        $this->group_name = $group->group_name;
        $this->items = $group->items;
        $this->is_multiple = (bool) $group->is_multiple;
        $this->is_optional = (bool) $group->is_optional;
    }

    public function update(AdditionalProduct $group): bool
    {
        $this->validate();
        return $group->update([
            'group_name' => $this->group_name,
            'items' => $this->items,
            'is_multiple' => $this->is_multiple,
            'is_optional' => $this->is_optional
        ]);
    }
}
