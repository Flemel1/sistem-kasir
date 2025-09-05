<?php

namespace App\Models;

use App\Models\Pivots\ProductsAdditionalProductPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_takeaway_price',
        'category_id'
    ];

    protected $with = ['category'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    // Get Table ProductsAdditionalProducts
    public function additional_product_ids(): HasMany
    {
        return $this->hasMany(
            ProductsAdditionalProducts::class,
            'product_id',
            'id'
        );
    }

    // Get Table AdditionalProduct
    public function additional_products(): BelongsToMany
    {
        return $this->belongsToMany(
            AdditionalProduct::class,
            'products_additional_products',
            'product_id',
            'additional_product_id'
        )->using(ProductsAdditionalProductPivot::class)->wherePivotNull('deleted_at');
    }

}
