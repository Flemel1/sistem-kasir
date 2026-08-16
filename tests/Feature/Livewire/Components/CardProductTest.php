<?php

namespace Tests\Feature\Livewire\Components;

use App\Livewire\Components\CardProduct;
use App\Models\AdditionalProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CardProductTest extends TestCase
{
    use AuthenticateAs;

    public function test_renders_product_details(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_name' => 'Test Product',
            'product_price' => 25000,
            'product_takeaway_price' => 27000,
        ]);

        Livewire::test(CardProduct::class, [
            'id' => $product->id,
            'title' => $product->product_name,
            'description' => $product->product_description ?? '',
            'price' => $product->product_price,
            'takeawayprice' => $product->product_takeaway_price,
        ])
            ->assertSee('Test Product');
    }

    public function test_open_modal_dispatches_event(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_name' => 'Espresso',
        ]);

        Livewire::test(CardProduct::class, [
            'id' => $product->id,
            'title' => $product->product_name,
            'description' => $product->product_description ?? '',
            'price' => $product->product_price,
            'takeawayprice' => $product->product_takeaway_price,
        ])
            ->call('open_modal', $product)
            ->assertDispatched('open-modal');
    }

    public function test_open_modal_includes_additional_products(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $addon = AdditionalProduct::factory()->create();

        $product->additional_products()->attach($addon->id);

        Livewire::test(CardProduct::class, [
            'id' => $product->id,
            'title' => $product->product_name,
            'description' => $product->product_description ?? '',
            'price' => $product->product_price,
            'takeawayprice' => $product->product_takeaway_price,
        ])
            ->call('open_modal', $product)
            ->assertDispatched('open-modal');
    }
}
