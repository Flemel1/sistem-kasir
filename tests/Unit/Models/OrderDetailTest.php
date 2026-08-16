<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class OrderDetailTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $detail = new OrderDetail();
        $this->assertEquals(['product_id', 'order_id', 'amount'], $detail->getFillable());
    }

    public function test_uses_soft_deletes(): void
    {
        $detail = new OrderDetail();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($detail));
    }

    public function test_has_orders_relationship(): void
    {
        $detail = new OrderDetail();
        $relation = $detail->orders();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(Order::class, $relation->getRelated());
    }

    public function test_has_product_relationship(): void
    {
        $detail = new OrderDetail();
        $relation = $detail->product();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(Product::class, $relation->getRelated());
    }
}
