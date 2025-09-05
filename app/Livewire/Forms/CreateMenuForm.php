<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateMenuForm extends Form
{
    
    #[Validate(rule: 'required|string|min:3|max:150')]
    public string $product_name;

    #[Validate(rule: 'required|string|min:3|max:150')]
    public string $product_description;

    #[Validate(rule: 'required|string|min:3|max:11|regex:/^\d+$/')]
    public string $product_price;

    #[Validate(rule: 'required|string|min:3|max:11|regex:/^\d+$/')]
    public string $product_takeaway_price;

    #[Validate(rule: 'required|string')]
    public string $category_id;

    public function setProduct(Product $product): void
    {
        $this->product_name = $product->product_name;
        $this->product_description = $product->product_description;
        $this->product_price = $product->product_price;
        $this->product_takeaway_price = $product->product_takeaway_price;
        $this->category_id = $product->category_id;
    }

    public function store(): bool
    {
        $this->validate();

        DB::beginTransaction();

        $product = Product::create($this->all());

        if ($product) {
            DB::commit();

            return true;
        }

        DB::rollBack();

        return false;
    }

    public function update(Product $product): bool
    {
        $this->validate();

        DB::beginTransaction();

        $product = $product->update($this->all());

        if ($product) {
            DB::commit();

            return true;
        }

        DB::rollBack();

        return false;
    }
}
