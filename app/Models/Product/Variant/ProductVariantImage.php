<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Product;
use App\Models\Product\Variant\ProductVariant;
//use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantImage extends Model
{
    //use SoftDeletes;
    protected $fillable = [
        "name",
        //"imagen",
        "size",
        "type",
        "companie_id",
        "product_id",
        "product_variant_id",
    ];

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set("America/Mexico_City");
        $this->attributes["created_at"] = Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set("America/Mexico_City");
        $this->attributes["updated_at"] = Carbon::now();
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}

