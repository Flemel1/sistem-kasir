<?php

namespace App\Livewire\Components;

use App\Models\CardProduct as ModelsCardProduct;
use App\Models\Product;
use Livewire\Component;

class CardProduct extends Component
{
    public ModelsCardProduct $model;


    public function mount(string $id, string $title, string $description, string $price, string $takeawayprice)
    {
        $this->model = new ModelsCardProduct(
            id: $id,
            title: $title,
            description: $description,
            price: $price,
            takeaway_price: $takeawayprice
        );
    }

    public function open_modal(Product $product)
    {
        $additional_products = $product::where('id', $product->id)
            ->withWhereHas('additional_products')
            ->first()->additional_products ?? collect([]);
        $data = [
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'product_price' => $product->product_price,
            'product_takeaway_price' => $product->product_takeaway_price,
            'additional_products' => $additional_products
        ];
        $this->dispatch(
            'open-modal',
            data: $data
        );
    }

    public function render()
    {
        return view('livewire.components.card-product');
    }
}
