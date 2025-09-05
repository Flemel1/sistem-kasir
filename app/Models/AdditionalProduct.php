<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'group_name',
        'items',
        'is_multiple',
        'is_optional'
    ];

    protected $casts = [
        'items' => 'array',
        'is_multiple' => 'boolean',
        'is_optional' => 'boolean'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_additional_products', 'additional_product_id', 'product_id');
    }
}
