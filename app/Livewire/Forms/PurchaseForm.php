<?php

namespace App\Livewire\Forms;

use App\Models\Purchase;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PurchaseForm extends Form
{
    #[Validate(rule: 'required|string|max:100')]
    public string $purchase_item_name;
    #[Validate(rule: 'required|numeric|regex:/^\d+$/')]
    public string $purchase_amount;
    #[Validate(rule: 'required|numeric|regex:/^\d+$/')]
    public string $purchase_money;

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
