<?php

namespace Tests\Unit\Models;

use App\Models\Purchase;
use PHPUnit\Framework\TestCase;

class PurchaseTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $purchase = new Purchase();
        $this->assertEquals(['purchase_item_name', 'purchase_amount', 'purchase_money'], $purchase->getFillable());
    }

    public function test_uses_soft_deletes(): void
    {
        $purchase = new Purchase();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($purchase));
    }
}
