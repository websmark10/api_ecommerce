<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Variant\ProductVariantDimension;
use App\Models\Product\Variant\ProductVariantDimCat;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\Variant\ProductVariantAttribute;
use App\Models\Product\Variant\ProductVariant;

class ProductVariantDimension extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "id",
        "name",
        "ref",
        "product_variant_dim_cat_id",
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

    public function product_variant_dimensions()
    {
        return $this->hasMany(ProductVariantDimension::class);

    }

    public function product_variant_dim_cats(){
        return $this->belongsTo(ProductVariantDimCat::class);
    }


    public function product_variant_dimension_attributes(){
        return $this->hasManyThrough(ProductVariantAttribute::class,ProductVariant::class,"product_variant_attribute_id","","","");
    }

}
