<?php

namespace App\Livewire\MasterData;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Menu extends Component
{
    use WithPagination;
    
    public function mount(): void
    {

    }

    public function render()
    {
        return view('livewire.master-data.menu', [
            'products' => Product::paginate(10)
        ]);
    }
}
