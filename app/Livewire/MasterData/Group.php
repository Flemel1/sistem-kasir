<?php

namespace App\Livewire\MasterData;

use App\Models\AdditionalProduct;
use Livewire\Component;
use Livewire\WithPagination;

class Group extends Component
{

    use WithPagination;

    public function render()
    {
        return view('livewire.master-data.group', [
            'groups' => AdditionalProduct::paginate(10)
        ]);
    }
}
