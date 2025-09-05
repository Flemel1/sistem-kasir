<?php

namespace App\Livewire\MasterData;

use App\Livewire\Forms\CreateCategoryForm;
use App\Models\ProductCategory;
use Exception;
use Livewire\Component;

class EditCategory extends Component
{
    public ProductCategory $category;
    public CreateCategoryForm $form;
    
    public function mount(ProductCategory $category)
    {
        $this->category = $category;
        $this->form->setCategory($category);
    }

    public function update()
    {
        try {
            $isUpdated = $this->form->update($this->category);
            
            if ($isUpdated) {
                $this->dispatch('update-category', [
                    'type' => 'success',
                    'message' => 'Kategori berhasil diubah'
                ]);
            } else {
                $this->dispatch('update-category', [
                    'type' => 'error',
                    'message' => 'Kategori gagal diubah'
                ]);
            }
        } catch (Exception $ex) {
            
            $this->dispatch('update-category', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.edit-category');
    }
}
