<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\PurchaseForm;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreatePurchaseReport extends Component
{
    public PurchaseForm $form;

    public function store()
    {
        try {
            $this->form->save();
            $this->dispatch('create-purchase', [
                'type' => 'success',
                'message' => 'Berhasil membuat data pembelian'
            ]);
            $this->redirectRoute('purchase');
        } catch (ValidationException $ex) {
            $this->dispatch('create-purchase', [
                'type' => 'error',
                'message' => 'Maaf terjadi kesalahan pada input data'
            ]);
        } catch (Exception $ex) {
            $this->dispatch('create-purchase', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pages.create-purchase-report');
    }
}
