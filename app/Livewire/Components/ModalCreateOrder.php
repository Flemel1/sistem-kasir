<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\CreateOrderForm;
use App\Models\OpenOrder;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Livewire\Component;

class ModalCreateOrder extends Component
{
    public CreateOrderForm $form;

    public function mount(Request $request)
    {
        $openBillID = $request->query('open_bill_id');
        if ($openBillID) {

            try {
                $openBill = OpenOrder::findOrFail($openBillID);
                $this->form->customer_name = $openBill->customer_name;
            } catch (ModelNotFoundException $ex) {
                abort(404);
            } catch (Exception $th) {
                abort(500);
            }
        }
    }

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
            cash_money: $this->form->cash_money,
            status_order: $this->form->status_order
        );
    }

    public function render()
    {
        return view('livewire.components.modal-create-order');
    }
}
