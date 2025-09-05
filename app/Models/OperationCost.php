<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationCost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cost_name',
        'cost_description',
        'cost_nominal'
    ];
}
