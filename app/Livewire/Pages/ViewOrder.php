<?php

namespace App\Livewire\Pages;

use App\Models\Order;
use Livewire\Component;

class ViewOrder extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
         $this->order = $order;
    }

    public function render()
    {
        return view('livewire.pages.view-order');
    }
}
