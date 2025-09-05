<?php

namespace App\Livewire\Forms;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateCategoryForm extends Form
{
    #[Validate('required|string|min:3|max:100|unique:product_categories,category_name')]
    public string $category_name;

    public function setCategory(ProductCategory $category): void
    {
        $this->category_name = $category->category_name;
    }

    public function save(): bool
    {
        $this->validate();
        DB::beginTransaction();
        $category = ProductCategory::create([
            'category_name' => $this->category_name
        ]);

        if ($category) {
            DB::commit();
            return true;
        }

        DB::rollBack();
        return false;
    }

    public function update(ProductCategory $category): bool
    {
        $this->validate();

        DB::beginTransaction();

        $category = $category->update($this->all());

        if ($category) {
            DB::commit();

            return true;
        }

        DB::rollBack();

        return false;
    }
}
