<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\EditMenu;
use App\Models\AdditionalProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductsAdditionalProducts;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class EditMenuTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('master-data.menu.edit', $product));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_edit_menu_page(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('master-data.menu.edit', $product));
        $response->assertOk();
    }

    public function test_can_update_product(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_name' => 'Old Name',
        ]);

        Livewire::test(EditMenu::class, ['product' => $product])
            ->set('form.product_name', 'Updated Name')
            ->set('form.product_description', $product->product_description)
            ->set('form.product_price', (string) $product->product_price)
            ->set('form.product_takeaway_price', (string) $product->product_takeaway_price)
            ->set('form.category_id', (string) $category->id)
            ->call('update')
            ->assertDispatched('update-product');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'product_name' => 'Updated Name',
        ]);
    }

    public function test_can_add_additional_product_to_menu(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $additionalProduct = AdditionalProduct::factory()->create();

        Livewire::test(EditMenu::class, ['product' => $product])
            ->call('add_additional_product', $additionalProduct->id);

        $this->assertDatabaseHas('products_additional_products', [
            'product_id' => $product->id,
            'additional_product_id' => $additionalProduct->id,
        ]);
    }

    public function test_can_remove_additional_product_from_menu(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $additionalProduct = AdditionalProduct::factory()->create();
        ProductsAdditionalProducts::factory()->create([
            'product_id' => $product->id,
            'additional_product_id' => $additionalProduct->id,
        ]);

        Livewire::test(EditMenu::class, ['product' => $product])
            ->call('delete_additional_product', $additionalProduct->id);

        $this->assertSoftDeleted('products_additional_products', [
            'product_id' => $product->id,
            'additional_product_id' => $additionalProduct->id,
        ]);
    }
}
