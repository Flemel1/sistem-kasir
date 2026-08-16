<?php

namespace App\Livewire\MasterData;

use App\Livewire\Forms\CreateMenuForm;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreateMenu extends Component
{
    public Collection $categories;
    public CreateMenuForm $form;

    public function mount(): void
    {
        $this->categories = ProductCategory::all();
    }

    public function save(): void
    {
        try {
            $isCreated = $this->form->store();

            if ($isCreated) {
                $this->dispatch('create-product', [
                    'type' => 'success',
                    'message' => 'Produk berhasil dibuat'
                ]);
            } else {
                $this->dispatch('create-product', [
                    'type' => 'error',
                    'message' => 'Produk gagal dibuat'
                ]);
            }
        } catch (ValidationException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            $this->dispatch('create-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.create-menu');
    }
}
