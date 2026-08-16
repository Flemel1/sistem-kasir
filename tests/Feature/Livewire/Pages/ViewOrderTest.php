<?php

namespace Tests\Feature\Livewire\Pages;

use App\Enums\StatusOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ViewOrderTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $order = Order::factory()->create(['status_order' => StatusOrder::CLOSED]);
        OrderDetail::factory()->create(['order_id' => $order->id, 'product_id' => $product->id]);

        $response = $this->get(route('order.view', $order));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_order_details(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'product_name' => 'Test Product',
        ]);
        $order = Order::factory()->create([
            'customer_name' => 'Test Customer',
            'total_payment' => 50000,
            'status_order' => StatusOrder::CLOSED,
        ]);
        OrderDetail::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'amount' => 2,
        ]);

        $response = $this->get(route('order.view', $order));
        $response->assertOk();
    }
}
