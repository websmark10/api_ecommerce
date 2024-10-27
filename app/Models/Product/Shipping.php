<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable=[
        'code',
        'name',
        'value',
        'store_id',
        'companie_id',
        'state_id'
    ];
}
