<?php

namespace App\Livewire\Pages;

use App\Models\OpenOrder;
use Livewire\Component;

class OpenBill extends Component
{
    public function render()
    {
        return view('livewire.pages.open-bill', [
            'orders' => OpenOrder::whereNull('doned_at')->orderByDesc('created_at')->paginate(10)
        ]);
    }
}
