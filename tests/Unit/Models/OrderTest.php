<?php

namespace Tests\Unit\Models;

use App\Enums\StatusOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $order = new Order();
        $this->assertEquals([
            'customer_name',
            'total_payment',
            'cash_money',
            'change_money',
            'status_order',
        ], $order->getFillable());
    }

    public function test_casts_status_order_to_enum(): void
    {
        $order = new Order();
        $casts = $order->getCasts();
        $this->assertArrayHasKey('status_order', $casts);
        $this->assertEquals(StatusOrder::class, $casts['status_order']);
    }

    public function test_uses_soft_deletes(): void
    {
        $order = new Order();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($order));
    }

    public function test_has_order_details_relationship(): void
    {
        $order = new Order();
        $relation = $order->order_details();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(OrderDetail::class, $relation->getRelated());
    }
}
