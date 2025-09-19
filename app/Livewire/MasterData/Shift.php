<?php

namespace App\Livewire\MasterData;

use App\Models\Shift as ModelsShift;
use Livewire\Component;

class Shift extends Component
{
    public function render()
    {
        return view('livewire.master-data.shift', [
            'shifts' => ModelsShift::paginate(10)
        ]);
    }
}
