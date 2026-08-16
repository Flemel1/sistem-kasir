<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $category = new ProductCategory();
        $this->assertEquals(['category_name'], $category->getFillable());
    }

    public function test_uses_soft_deletes(): void
    {
        $category = new ProductCategory();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($category));
    }

    public function test_has_product_relationship(): void
    {
        $category = new ProductCategory();
        $relation = $category->product();
        $this->assertInstanceOf(HasOne::class, $relation);
        $this->assertEquals('category_id', $relation->getForeignKeyName());
        $this->assertInstanceOf(Product::class, $relation->getRelated());
    }
}
