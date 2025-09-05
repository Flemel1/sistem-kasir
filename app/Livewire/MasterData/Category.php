<?php

namespace App\Livewire\MasterData;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public function mount() : void {
      
    }

    public function render()
    {
        return view('livewire.master-data.category', [
            'categories' => ProductCategory::paginate(10)
        ]);
    }
}
