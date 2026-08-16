<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\ViewMenu;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ViewMenuTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('master-data.menu.view', $product));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_product_details(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_name' => 'Test Product',
        ]);

        $response = $this->get(route('master-data.menu.view', $product));
        $response->assertOk();
    }

    public function test_can_delete_product(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        Livewire::test(ViewMenu::class, ['product' => $product])
            ->call('delete', $product)
            ->assertDispatched('delete-product');

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
