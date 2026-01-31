<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateMenuForm extends Form
{
    
    public string $product_name;

    public string $product_description;

    public string $product_price;

    public string $product_takeaway_price;

    public string $category_id;

    public function rules(): array
    {
        return [
            'product_name' => 'required|string|min:3|max:150',
            'product_description' => 'required|string|min:1|max:150',
            'product_price' => 'required|string|min:3|max:11|regex:/^\d+$/',
            'product_takeaway_price' => 'required|string|min:3|max:11|regex:/^\d+$/',
            'category_id' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'product_name.required' => 'Nama produk wajib diisi',
            'product_name.min' => 'Nama produk minimal 3 karakter',
            'product_name.max' => 'Nama produk maksimal 150 karakter',
            'product_description.min' => 'Deskripsi produk minimal 1 karakter',
            'product_description.max' => 'Deskripsi produk maksimal 150 karakter',
            'product_description.required' => 'Deskripsi produk wajib diisi',
            'product_price.required' => 'Harga produk wajib diisi',
            'product_price.min' => 'Harga produk minimal 3 karakter',
            'product_price.max' => 'Harga produk maksimal 11 karakter',
            'product_price.regex' => 'Harga produk harus berupa angka',
            'product_takeaway_price.required' => 'Harga produk takeaway wajib diisi',
            'product_takeaway_price.min' => 'Harga produk takeaway minimal 3 karakter',
            'product_takeaway_price.max' => 'Harga produk takeaway maksimal 11 karakter',
            'product_takeaway_price.regex' => 'Harga produk takeaway harus berupa angka',
            'category_id.required' => 'Kategori produk wajib diisi',
        ];
    }

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
