<?php

namespace Tests\Feature\Livewire\Components;

use App\Livewire\Components\ModalOrder;
use App\Models\AdditionalProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ModalOrderTest extends TestCase
{
    use AuthenticateAs;

    public function test_can_open_modal_with_product_data(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_name' => 'Latte',
            'product_price' => 25000,
            'product_takeaway_price' => 27000,
        ]);

        Livewire::test(ModalOrder::class)
            ->dispatch('open-modal', data: [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_takeaway_price' => $product->product_takeaway_price,
                'additional_products' => [],
            ])
            ->assertSet('product_name', 'Latte');
    }

    public function test_can_increase_amount(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $component = Livewire::test(ModalOrder::class)
            ->dispatch('open-modal', data: [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_takeaway_price' => $product->product_takeaway_price,
                'additional_products' => [],
            ]);

        $component->call('increase_amount');
        $this->assertEquals(2, $component->get('form.amount'));
    }

    public function test_can_decrease_amount(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $component = Livewire::test(ModalOrder::class)
            ->dispatch('open-modal', data: [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_takeaway_price' => $product->product_takeaway_price,
                'additional_products' => [],
            ]);

        $component->call('increase_amount');
        $component->call('decrease_amount');
        $this->assertEquals(1, $component->get('form.amount'));
    }

    public function test_amount_cannot_go_below_one(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $component = Livewire::test(ModalOrder::class)
            ->dispatch('open-modal', data: [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_takeaway_price' => $product->product_takeaway_price,
                'additional_products' => [],
            ]);

        $component->call('decrease_amount');
        $this->assertEquals(1, $component->get('form.amount'));
    }

    public function test_submit_dispatches_add_product_event(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        Livewire::test(ModalOrder::class)
            ->dispatch('open-modal', data: [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_takeaway_price' => $product->product_takeaway_price,
                'additional_products' => [],
            ])
            ->call('submit')
            ->assertDispatched('add-product');
    }

    public function test_submit_with_additional_products_includes_them(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $addon = AdditionalProduct::factory()->create([
            'items' => [['item_name' => 'Extra Shot', 'item_price' => 3000]],
            'is_multiple' => false,
            'is_optional' => true,
        ]);

        $product->additional_products()->attach($addon->id);

        Livewire::test(ModalOrder::class)
            ->dispatch('open-modal', data: [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_takeaway_price' => $product->product_takeaway_price,
                'additional_products' => [
                    ['id' => $addon->id, 'group_name' => 'Addon', 'items' => [['item_name' => 'Extra Shot', 'item_price' => 3000]], 'is_multiple' => false, 'is_optional' => true],
                ],
            ])
            ->call('submit')
            ->assertDispatched('add-product');
    }

    public function test_can_close_modal(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        Livewire::test(ModalOrder::class)
            ->dispatch('open-modal', data: [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_takeaway_price' => $product->product_takeaway_price,
                'additional_products' => [],
            ])
            ->call('close')
            ->assertDispatched('close-modal');
    }
}
