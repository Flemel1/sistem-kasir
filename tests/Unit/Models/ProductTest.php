<?php

namespace Tests\Unit\Models;

use App\Models\AdditionalProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductsAdditionalProducts;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $product = new Product();
        $this->assertEquals([
            'product_name',
            'product_description',
            'product_price',
            'product_takeaway_price',
            'category_id',
        ], $product->getFillable());
    }

    public function test_uses_soft_deletes(): void
    {
        $product = new Product();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($product));
    }

    public function test_has_category_relationship(): void
    {
        $product = new Product();
        $relation = $product->category();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(ProductCategory::class, $relation->getRelated());
    }

    public function test_has_additional_product_ids_relationship(): void
    {
        $product = new Product();
        $relation = $product->additional_product_ids();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(ProductsAdditionalProducts::class, $relation->getRelated());
    }

    public function test_has_additional_products_relationship(): void
    {
        $product = new Product();
        $relation = $product->additional_products();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertInstanceOf(AdditionalProduct::class, $relation->getRelated());
        $this->assertEquals('products_additional_products', $relation->getTable());
    }
}
