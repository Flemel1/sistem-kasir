<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\ViewCategory;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ViewCategoryTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $category = ProductCategory::factory()->create();

        $response = $this->get(route('master-data.category.view', $category));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_category_details(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create(['category_name' => 'Test Cat']);

        $response = $this->get(route('master-data.category.view', $category));
        $response->assertOk();
    }

    public function test_can_delete_category(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();

        Livewire::test(ViewCategory::class, ['category' => $category])
            ->call('delete', $category)
            ->assertDispatched('delete-category');

        $this->assertSoftDeleted('product_categories', ['id' => $category->id]);
    }
}
