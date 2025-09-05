<?php

namespace App\Livewire\MasterData;

use App\Models\ProductCategory;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewCategory extends Component
{

    public ProductCategory $category;

    public function mount(ProductCategory $category): void
    {
        $this->category = $category;
    }

    public function delete(ProductCategory $category): void
    {
        try {
            DB::beginTransaction();
            $isDeleted = $category->delete();
            if ($isDeleted) {
                DB::commit();
                $this->dispatch('delete-category', [
                    'type' => 'success',
                    'message' => 'Kategori berhasil dihapus'
                ]);
            } else {
                DB::rollBack();
                $this->dispatch('delete-category', [
                    'type' => 'error',
                    'message' => 'Kategori gagal dihapus'
                ]);
            }
        } catch (Exception $ex) {
            DB::rollBack();
            $this->dispatch('delete-category', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.view-category');
    }
}
