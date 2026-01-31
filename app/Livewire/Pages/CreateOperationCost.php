<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\CreateOperationCostForm;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreateOperationCost extends Component
{
    public CreateOperationCostForm $form;

    public function store()
    {
        try {
            $this->form->save();
            $this->dispatch('create-operation-cost', [
                'type' => 'success',
                'message' => 'Berhasil membuat data biaya operasional'
            ]);
            $this->redirectRoute('operation-cost');
        } catch (ValidationException $ex) {
            $this->dispatch('create-operation-cost', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('create-operation-cost', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pages.create-operation-cost');
    }
}
