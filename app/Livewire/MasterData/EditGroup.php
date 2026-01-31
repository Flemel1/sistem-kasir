<?php

namespace App\Livewire\MasterData;

use App\Livewire\Forms\CreateAdditionalProductForm;
use App\Models\AdditionalProduct;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EditGroup extends Component
{
    public AdditionalProduct $group;
    public CreateAdditionalProductForm $form;

    public function mount(AdditionalProduct $group)
    {
        $this->group = $group;
        $this->form->setGroup($group);
    }

    public function add_item()
    {
        $this->form->items[] = [];
    }

    public function delete_item()
    {
        array_pop($this->form->items);
    }

    public function update()
    {
        try {
            $isUpdated = $this->form->update($this->group);
            if ($isUpdated) {
                $this->dispatch('update-group-product', [
                    'type' => 'success',
                    'message' => 'Produk tambahan berhasil diubah'
                ]);
            } else {
                $this->dispatch('update-group-product', [
                    'type' => 'error',
                    'message' => 'Produk tambahan gagal diubah'
                ]);
            }
        } catch (ValidationException $ex) {
            $this->dispatch('update-group-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('update-group-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.edit-group');
    }
}
