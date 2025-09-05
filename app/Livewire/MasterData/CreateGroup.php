<?php

namespace App\Livewire\MasterData;

use App\Livewire\Forms\CreateAdditionalProductForm;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreateGroup extends Component
{
    public CreateAdditionalProductForm $form;

    public function add_item()
    {
        $this->form->items[] = [];
    }

    public function delete_item()
    {
        array_pop($this->form->items);
    }
    
    public function store()
    {
        try {
            $isCreated = $this->form->store();
            if ($isCreated) {
                $this->dispatch('create-group-product', [
                    'type' => 'success',
                    'message' => 'Group produk berhasil dibuat'
                ]);
            } else {
                $this->dispatch('create-group-product', [
                    'type' => 'error',
                    'message' => 'Group produk gagal dibuat'
                ]);
            }
        } catch (ValidationException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            $this->dispatch('create-group-product', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.create-group');
    }
}
