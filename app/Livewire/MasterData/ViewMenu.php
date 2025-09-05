<?php

namespace App\Livewire\MasterData;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ViewMenu extends Component
{

    use WithPagination;

    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function delete(Product $product): void
    {
        try {
            DB::beginTransaction();

            $isDeleted = $product->delete();
            if ($isDeleted) {
                DB::commit();
                $this->dispatch('delete-product', [
                    'type' => 'success',
                    'message' => 'Produk berhasil dihapus'
                ]);
            } else {
                DB::rollBack();
                $this->dispatch('delete-product', [
                    'type' => 'error',
                    'message' => 'Produk gagal dihapus'
                ]);
            }
        } catch (Exception $ex) {
            DB::rollBack();
            $this->dispatch('delete-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.view-menu');
    }
}
