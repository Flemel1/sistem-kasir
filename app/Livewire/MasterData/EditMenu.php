<?php

namespace App\Livewire\MasterData;

use App\Livewire\Forms\CreateMenuForm;
use App\Models\AdditionalProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductsAdditionalProducts;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class EditMenu extends Component
{

    public Product $product;
    public Collection $categories;
    public Collection $active_additional_products;
    public CreateMenuForm $form;

    public function mount(Product $product)
    {
        $this->product = Product::with('additional_product_ids')->where('id', '=', $product->id)->first();
        $this->categories = ProductCategory::all();
        $this->form->setProduct($product);
    }

    public function update()
    {
        try {
            $isUpdated = $this->form->update($this->product);

            if ($isUpdated) {
                $this->dispatch('update-product', [
                    'type' => 'success',
                    'message' => 'Produk berhasil diubah'
                ]);
            } else {
                $this->dispatch('update-product', [
                    'type' => 'error',
                    'message' => 'Produk gagal diubah'
                ]);
            }
        } catch (Exception $ex) {

            $this->dispatch('update-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function add_additional_product(int $additional_id)
    {
        try {
            ProductsAdditionalProducts::create([
                'product_id' => $this->product->id,
                'additional_product_id' => $additional_id
            ]);
            $this->dispatch('update-product', [
                'type' => 'success',
                'message' => 'Produk berhasil diubah'
            ]);
        } catch (Exception $ex) {
            $this->dispatch('update-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete_additional_product(int $additional_id)
    {
        try {
            $instance = ProductsAdditionalProducts::where('product_id', '=', $this->product->id)
                ->where('additional_product_id', '=', $additional_id)
                ->get()
                ->first();
            $instance->delete();
            $this->dispatch('update-product', [
                'type' => 'success',
                'message' => 'Produk berhasil diubah'
            ]);
        } catch (Exception $ex) {
            $this->dispatch('update-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.edit-menu', [
            'groups' => AdditionalProduct::paginate(10)
        ]);
    }
}
