<?php

namespace Tests\Unit\Models;

use App\Models\OpenOrder;
use PHPUnit\Framework\TestCase;

class OpenOrderTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $openOrder = new OpenOrder();
        $this->assertEquals(['customer_name', 'ordered_items', 'grand_total', 'doned_at'], $openOrder->getFillable());
    }

    public function test_casts(): void
    {
        $openOrder = new OpenOrder();
        $casts = $openOrder->getCasts();
        $this->assertArrayHasKey('ordered_items', $casts);
        $this->assertEquals('array', $casts['ordered_items']);
        $this->assertArrayHasKey('doned_at', $casts);
        $this->assertEquals('datetime', $casts['doned_at']);
    }

    public function test_uses_soft_deletes(): void
    {
        $openOrder = new OpenOrder();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($openOrder));
    }
}
