<?php

namespace App\Livewire\Pages;

use App\Models\OperationCost as ModelsOperationCost;
use Livewire\Component;
use Livewire\WithPagination;

class OperationCost extends Component
{
    use WithPagination;

    
    public function render()
    {
        return view('livewire.pages.operation-cost', [
            'costs' => ModelsOperationCost::paginate(10)
        ]);
    }
}
