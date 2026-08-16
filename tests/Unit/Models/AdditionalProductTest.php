<?php

namespace Tests\Unit\Models;

use App\Models\AdditionalProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class AdditionalProductTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $model = new AdditionalProduct();
        $this->assertEquals(['group_name', 'items', 'is_multiple', 'is_optional'], $model->getFillable());
    }

    public function test_casts(): void
    {
        $model = new AdditionalProduct();
        $casts = $model->getCasts();
        $this->assertArrayHasKey('items', $casts);
        $this->assertEquals('array', $casts['items']);
        $this->assertArrayHasKey('is_multiple', $casts);
        $this->assertEquals('boolean', $casts['is_multiple']);
        $this->assertArrayHasKey('is_optional', $casts);
        $this->assertEquals('boolean', $casts['is_optional']);
    }

    public function test_uses_soft_deletes(): void
    {
        $model = new AdditionalProduct();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($model));
    }

    public function test_has_products_relationship(): void
    {
        $model = new AdditionalProduct();
        $relation = $model->products();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertInstanceOf(Product::class, $relation->getRelated());
    }
}
