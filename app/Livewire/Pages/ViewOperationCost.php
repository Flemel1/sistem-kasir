<?php

namespace App\Livewire\Pages;

use App\Models\OperationCost;
use Livewire\Component;

class ViewOperationCost extends Component
{
    public OperationCost $cost;

    public function mount(OperationCost $cost)
    {
        $this->cost = $cost;
    }
    
    public function render()
    {
        return view('livewire.pages.view-operation-cost');
    }
}
