<?php

namespace App\Livewire\Pages;

use App\Models\Purchase;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseReport extends Component
{

    use WithPagination;

    public function render()
    {
        return view('livewire.pages.purchase-report', [
            'purchases' => Purchase::paginate(10)
        ]);
    }
}
