<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\PurchaseForm;
use App\Models\Purchase;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EditPurchaseReport extends Component
{
    public PurchaseForm $form;
    public Purchase $purchase;

    public function mount(Purchase $purchase)
    {
        $this->purchase = $purchase;
        $this->form->setPurchase($purchase);
    }

    public function update()
    {
        try {
            $this->form->update($this->purchase);

            $this->dispatch('update-purchase', [
                'type' => 'success',
                'message' => 'Berhasil edit data pembelian'
            ]);
            $this->redirectRoute('purchase.view', ['purchase' => $this->purchase]);
        } catch (ValidationException $ex) {
            $this->dispatch('update-purchase', [
                'type' => 'error',
                'message' => 'Maaf terjadi kesalahan pada input data'
            ]);
        } catch (Exception $ex) {
            $this->dispatch('update-purchase', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pages.edit-purchase-report');
    }
}
