<?php

namespace App\Livewire\Pages;

use App\Models\Order as ModelsOrder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Order extends Component
{
    use WithPagination;

    public function mount(): void
    {

    }

    public function render()
    {
        return view('livewire.pages.order', [
            'orders' => ModelsOrder::orderByDesc('created_at')->paginate(10)
        ]);
    }
}
