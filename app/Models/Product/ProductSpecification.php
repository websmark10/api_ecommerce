<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product\Variant\ProductVariantDimension;
use App\Models\Product\Variant\ProductVariantAttribute;
use App\Models\Product\Variant\ProductVariantAttrCat;

class ProductSpecification extends Model
{
    // use HasFactory;
    // use SoftDeletes;
    protected $fillable = [
        "product_id",
        "cat_attribute_id",
        "attribute_id",
        "value",
        "state_id",
        "companie_id"

    ];

    public function setCreatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"] = Carbon::now();
    }
    public function setUpdatedtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"] = Carbon::now();
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function attribute(){
        return $this->belongsTo(ProductVariantAttribute::class ,"attribute_id","id");
    }
    public function cat_attribute(){
        return $this->belongsTo(ProductVariantAttrCat::class ,"cat_attribute_id","id");
    }

}
