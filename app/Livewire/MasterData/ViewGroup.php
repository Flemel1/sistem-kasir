<?php

namespace App\Livewire\MasterData;

use App\Models\AdditionalProduct;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewGroup extends Component
{
    public AdditionalProduct $group;

    public function mount(AdditionalProduct $group)
    {
        $this->group = $group;
    }

    public function delete()
    {
        try {
            DB::beginTransaction();

            $isDeleted = $this->group->delete();
            if ($isDeleted) {
                DB::commit();
                $this->dispatch('delete-group-product', [
                    'type' => 'success',
                    'message' => 'Produk tambahan berhasil dihapus'
                ]);
            } else {
                DB::rollBack();
                $this->dispatch('delete-group-product', [
                    'type' => 'error',
                    'message' => 'Produk tambahan gagal dihapus'
                ]);
            }
        } catch (Exception $ex) {
            DB::rollBack();
            $this->dispatch('delete-group-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.view-group');
    }
}
