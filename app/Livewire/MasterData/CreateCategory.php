<?php

namespace App\Livewire\MasterData;

use App\Livewire\Forms\CreateCategoryForm;
use Livewire\Component;

class CreateCategory extends Component
{
    public CreateCategoryForm $form;

    public function store()
    {
        $isSuccess = $this->form->save();

        if ($isSuccess) {
            $this->redirectRoute('master-data.category');
        }
    }
    
    public function render()
    {
        return view('livewire.master-data.create-category');
    }
}
