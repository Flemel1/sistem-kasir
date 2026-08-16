<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\EditCategory;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class EditCategoryTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $category = ProductCategory::factory()->create();

        $response = $this->get(route('master-data.category.edit', $category));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_edit_category_page(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();

        $response = $this->get(route('master-data.category.edit', $category));
        $response->assertOk();
    }

    public function test_can_update_category(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create(['category_name' => 'Old Name']);

        Livewire::test(EditCategory::class, ['category' => $category])
            ->set('form.category_name', 'New Name')
            ->call('update')
            ->assertDispatched('update-category');

        $this->assertDatabaseHas('product_categories', [
            'id' => $category->id,
            'category_name' => 'New Name',
        ]);
    }
}
