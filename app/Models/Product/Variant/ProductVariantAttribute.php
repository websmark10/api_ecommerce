<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Variant\ProductVariantAttrCat;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\ProductSpecification;

class ProductVariantAttribute extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "id",
        "name",
        "ref",
        "product_variant_attr_cat_id",
       // "attribute_type_id",
        "state_id"
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

    public function variants(){
        return $this->hasMany(ProductVariant::class);

    }


    public function specifications(){
        return $this->hasMany(ProductSpecification::class);

    }

    public function cat_attribute(){
        return $this->belongsTo(ProductVariantAttrCat::class,"product_variant_attr_cat_id","id");
    }
  /*  public function product_variant_attr_cat(){
        return $this->belongsTo(ProductVariantAttrCat::class,"product_variant_attr_cat_id","id");
    }*/
}
