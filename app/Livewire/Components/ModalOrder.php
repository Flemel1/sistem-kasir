<?php

namespace App\Livewire\Components;

use App\Enums\PriceChoose;
use App\Livewire\Forms\AddProductOrderForm;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalOrder extends Component
{
    public AddProductOrderForm $form;

    public string $product_id = '';
    public string $product_name = '';
    public string $product_price = '';
    public string $product_takeaway_price = '';
    public $additional_products = [];
    public bool $is_create = false;
    public ?string $old_identifier = null;

    #[On('open-modal')]
    public function open(
        $data
    ): void {
        $this->is_create = true;
        $this->product_id = $data['product_id'];
        $this->product_name = $data['product_name'];
        $this->product_price = $data['product_price'];
        $this->product_takeaway_price = $data['product_takeaway_price'];
        $this->additional_products = $data['additional_products'];
    }

    #[On('open-edit-modal')]
    public function edit(
        $data
    ): void {
        $this->is_create = false;
        $input_multiple_additional_products = [];
        $input_single_additional_products = [];
        $currentProductProperties = $data['current_product_properties'];
        $this->old_identifier = $currentProductProperties['identifier'];
        $this->product_id = $currentProductProperties['product_id'];
        $this->product_name = $currentProductProperties['product_name'];
        $this->product_price = $currentProductProperties['price'];
        $this->product_takeaway_price = $currentProductProperties['takeaway_price'];
        $this->additional_products = $data['additional_products'];
        $this->form->amount = $currentProductProperties['amount'];
        if ($currentProductProperties['price_choose'] != 'normal') {
            $this->form->price_choose = PriceChoose::TAKEAWAY;
        }
        foreach ($currentProductProperties['additional_products'] as $key => $additional_product) {
            foreach ($additional_product as $item) {
                if ($item['type'] == 'multiple') {
                    $input_multiple_additional_products[] = $key . "_" . $item['name'] . "_" . $item['price'];
                } else {
                    $input_single_additional_products[$key] =  $item['name'] . "_" . $item['price'];
                }
            }
        }
        $this->form->input_multiple_additional_products = $input_multiple_additional_products;
        $this->form->input_single_additional_products = $input_single_additional_products;
    }

    public function increase_amount(): void
    {
        $this->form->amount = $this->form->amount + 1;
    }

    public function decrease_amount(): void
    {
        if ($this->form->amount > 1) {
            $this->form->amount = $this->form->amount - 1;
        }
    }

    public function close(): void
    {
        $this->form->reset();
        $this->dispatch('close-modal');
    }

    public function submit(): void
    {
        $this->form->validate();
        $additional_products = [];
        $identifier = null;
        if ($this->form->price_choose->value == PriceChoose::TAKEAWAY->value) {
            $identifier = $this->product_name . "_" . $this->product_id . "_" . "takeaway";
        } else {
            $identifier = $this->product_name . "_" . $this->product_id;
        }
        
        
        foreach ($this->form->input_multiple_additional_products as $item) {
            $arr_str = explode('_', $item);
            $identifier = $identifier . $arr_str[1] . "_";
            $additional_products[$arr_str[0]][] = [
                'name' => $arr_str[1],
                'price' => intval($arr_str[2]),
                'type' => 'multiple'
            ];
        }


        foreach ($this->form->input_single_additional_products as $key => $item) {
            $arr_str = explode('_', $item);
            $identifier = $identifier . $arr_str[1] . "_";
            $additional_products[$key][] = [
                'name' => $arr_str[0],
                'price' => intval($arr_str[1]),
                'type' => 'single'
            ];
        }

        
        if ($this->is_create) {
            $this->dispatch(
                'add-product',
                product_name: $this->product_name,
                product_id: $this->product_id,
                amount: $this->form->amount,
                price: $this->product_price,
                takeaway_price: $this->product_takeaway_price,
                price_choose: $this->form->price_choose,
                additional_products: $additional_products,
                identifier: base64_encode($identifier)
            );
        } else {

            $this->dispatch(
                'update-product',
                product_name: $this->product_name,
                product_id: $this->product_id,
                amount: $this->form->amount,
                price: $this->product_price,
                takeaway_price: $this->product_takeaway_price,
                price_choose: $this->form->price_choose,
                additional_products: $additional_products,
                old_identifier: $this->old_identifier,
                identifier: base64_encode($identifier)
            );
        }

        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.components.modal-order');
    }
}
