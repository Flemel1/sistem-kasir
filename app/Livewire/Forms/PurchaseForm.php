<?php

namespace App\Livewire\Forms;

use App\Models\Purchase;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PurchaseForm extends Form
{
    public string $purchase_item_name;

    public string $purchase_amount;

    public string $purchase_money;

    public function rules(): array
    {
        return [
            'purchase_item_name' => 'required|string|max:100',
            'purchase_amount' => 'required|numeric|regex:/^\d+$/',
            'purchase_money' => 'required|numeric|regex:/^\d+$/',
        ];
    }

    public function messages(): array
    {
        return [
            'purchase_item_name.required' => 'Nama barang wajib diisi',
            'purchase_item_name.max' => 'Nama barang maksimal 100 karakter',
            'purchase_amount.required' => 'Jumlah barang wajib diisi',
            'purchase_amount.numeric' => 'Jumlah barang harus berupa angka',
            'purchase_amount.regex' => 'Jumlah barang harus berupa angka',
            'purchase_money.required' => 'Harga barang wajib diisi',
            'purchase_money.numeric' => 'Harga barang harus berupa angka',
            'purchase_money.regex' => 'Harga barang harus berupa angka',
        ];
    }


    public function setPurchase(Purchase $purchase)
    {
        $this->purchase_item_name = $purchase->purchase_item_name;
        $this->purchase_amount = $purchase->purchase_amount;
        $this->purchase_money = $purchase->purchase_money;
    }

    public function update(Purchase $purchase)
    {
        $this->validate();

        $purchase->update($this->all());
    }

    public function save()
    {
        $this->validate();

        Purchase::create($this->all());
    }
}
