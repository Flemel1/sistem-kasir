<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\CreateOperationCostForm;
use App\Models\OperationCost;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EditOperationCost extends Component
{
    public CreateOperationCostForm $form;
    public OperationCost $cost;

    public function mount(OperationCost $cost)
    {
        $this->cost = $cost;
        $this->form->setOperationCost($cost);
    }

    public function update()
    {
        try {
            $this->form->update($this->cost);
            $this->dispatch('edit-operation-cost', [
                'type' => 'success',
                'message' => 'Berhasil mengubah data biaya operasional'
            ]);
            $this->redirectRoute('operation-cost');
        } catch (ValidationException $ex) {
            $this->dispatch('edit-operation-cost', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('edit-operation-cost', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pages.edit-operation-cost');
    }
}
