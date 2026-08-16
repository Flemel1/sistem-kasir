<?php

namespace Tests\Unit\Models;

use App\Models\OperationCost;
use PHPUnit\Framework\TestCase;

class OperationCostTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $cost = new OperationCost();
        $this->assertEquals(['cost_name', 'cost_description', 'cost_nominal'], $cost->getFillable());
    }

    public function test_uses_soft_deletes(): void
    {
        $cost = new OperationCost();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($cost));
    }
}
