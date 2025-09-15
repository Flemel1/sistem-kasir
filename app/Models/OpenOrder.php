<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpenOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_name',
        'ordered_items',
        'grand_total',
        'doned_at',
    ];
}
