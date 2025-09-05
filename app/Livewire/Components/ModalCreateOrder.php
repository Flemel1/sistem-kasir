<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\CreateOrderForm;
use Livewire\Component;

class ModalCreateOrder extends Component
{
    public CreateOrderForm $form;

    public function close(): void
    {
        $this->form->reset();
        $this->dispatch('close-create-order-modal');
    }

    public function save(): void
    {
        $this->form->validate();
        $this->dispatch(
            'create-order',
            customer_name: $this->form->customer_name,
            cash_money: $this->form->cash_money
        );
    }

    public function render()
    {
        return view('livewire.components.modal-create-order');
    }
}
