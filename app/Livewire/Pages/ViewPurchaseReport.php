<?php

namespace App\Livewire\Pages;

use App\Models\Purchase;
use Livewire\Component;

class ViewPurchaseReport extends Component
{
    public Purchase $purchase;

    public function mount(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function render()
    {
        return view('livewire.pages.view-purchase-report');
    }
}
