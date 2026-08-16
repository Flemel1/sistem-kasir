<?php

namespace Tests\Feature\Livewire\Pages;

use App\Livewire\Components\ModalCreateOrder;
use App\Livewire\Components\ModalOrder;
use App\Livewire\Pages\CreateOrder;
use App\Models\OpenOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CreateOrderTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('order.create'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_create_order_page(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->get(route('order.create'));
        $response->assertOk();
    }

    public function test_can_add_product_to_cart(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_price' => 25000,
        ]);

        $component = Livewire::test(CreateOrder::class);

        $component->dispatch('add-product', ...[
            'identifier' => base64_encode('test-1'),
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'amount' => 2,
            'price' => $product->product_price,
            'takeaway_price' => $product->product_takeaway_price,
            'price_choose' => 'normal',
            'additional_product_prices' => 0,
            'additional_products' => [],
        ]);

        $this->assertCount(1, $component->get('currentOrders'));
        $this->assertEquals(50000, $component->get('total'));
    }

    public function test_can_remove_product_from_cart(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $component = Livewire::test(CreateOrder::class);

        $identifier = base64_encode('test-1');
        $component->dispatch('add-product', ...[
            'identifier' => $identifier,
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'amount' => 1,
            'price' => $product->product_price,
            'takeaway_price' => $product->product_takeaway_price,
            'price_choose' => 'normal',
            'additional_product_prices' => 0,
            'additional_products' => [],
        ]);

        $this->assertCount(1, $component->get('currentOrders'));

        $component->call('remove_product', $identifier);
        $this->assertCount(0, $component->get('currentOrders'));
        $this->assertEquals(0, $component->get('total'));
    }

    public function test_can_create_closed_order(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_price' => 25000,
        ]);

        $component = Livewire::test(CreateOrder::class);

        $identifier = base64_encode('test-1');
        $component->dispatch('add-product', ...[
            'identifier' => $identifier,
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'amount' => 1,
            'price' => $product->product_price,
            'takeaway_price' => $product->product_takeaway_price,
            'price_choose' => 'normal',
            'additional_product_prices' => 0,
            'additional_products' => [],
        ]);

        $component->dispatch('create-order', ...[
            'customer_name' => 'Test Customer',
            'cash_money' => 30000,
            'status_order' => 'closed',
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Test Customer',
            'total_payment' => 25000,
            'cash_money' => 30000,
            'change_money' => 5000,
        ]);

        $this->assertDatabaseHas('order_details', [
            'product_id' => $product->id,
            'amount' => 1,
        ]);
    }

    public function test_can_create_open_bill(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_price' => 25000,
        ]);

        $component = Livewire::test(CreateOrder::class);

        $identifier = base64_encode('test-1');
        $component->dispatch('add-product', ...[
            'identifier' => $identifier,
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'amount' => 2,
            'price' => $product->product_price,
            'takeaway_price' => $product->product_takeaway_price,
            'price_choose' => 'normal',
            'additional_product_prices' => 0,
            'additional_products' => [],
        ]);

        $component->dispatch('create-order', ...[
            'customer_name' => 'Open Bill Customer',
            'cash_money' => 0,
            'status_order' => 'opened',
        ]);

        $this->assertDatabaseHas('open_orders', [
            'customer_name' => 'Open Bill Customer',
            'grand_total' => 50000,
        ]);
    }

    public function test_can_continue_open_bill(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_price' => 25000,
        ]);

        $openOrder = OpenOrder::create([
            'customer_name' => 'Existing Bill',
            'ordered_items' => [
                ['product_id' => $product->id, 'product_name' => $product->product_name, 'amount' => 1, 'price' => 25000],
            ],
            'grand_total' => 25000,
            'doned_at' => null,
        ]);

        $component = Livewire::test(CreateOrder::class, ['open_bill_id' => $openOrder->id]);

        $component->dispatch('add-product', ...[
            'identifier' => base64_encode('test-2'),
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'amount' => 1,
            'price' => $product->product_price,
            'takeaway_price' => $product->product_takeaway_price,
            'price_choose' => 'normal',
            'additional_product_prices' => 0,
            'additional_products' => [],
        ]);

        $component->dispatch('create-order', ...[
            'customer_name' => 'Existing Bill',
            'cash_money' => 50000,
            'status_order' => 'closed',
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Existing Bill',
        ]);

        $this->assertDatabaseHas('open_orders', [
            'id' => $openOrder->id,
        ]);

        $openOrder->refresh();
        $this->assertNotNull($openOrder->doned_at);
    }

    public function test_cannot_create_order_with_insufficient_cash(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_price' => 25000,
        ]);

        $component = Livewire::test(CreateOrder::class);

        $identifier = base64_encode('test-1');
        $component->dispatch('add-product', ...[
            'identifier' => $identifier,
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'amount' => 1,
            'price' => $product->product_price,
            'takeaway_price' => $product->product_takeaway_price,
            'price_choose' => 'normal',
            'additional_product_prices' => 0,
            'additional_products' => [],
        ]);

        $component->dispatch('create-order', ...[
            'customer_name' => 'Test',
            'cash_money' => 10000,
            'status_order' => 'closed',
        ]);

        $this->assertDatabaseMissing('orders', [
            'customer_name' => 'Test',
        ]);
    }
}
