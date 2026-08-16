<?php

namespace Tests\Unit\Models;

use App\Models\Shift;
use PHPUnit\Framework\TestCase;

class ShiftTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $shift = new Shift();
        $this->assertEquals(['employee_name', 'shift'], $shift->getFillable());
    }

    public function test_shift_is_cast_to_array(): void
    {
        $shift = new Shift();
        $casts = $shift->getCasts();
        $this->assertArrayHasKey('shift', $casts);
        $this->assertEquals('array', $casts['shift']);
    }

    public function test_uses_soft_deletes(): void
    {
        $shift = new Shift();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($shift));
    }
}
