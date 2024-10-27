<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Variant\ProductVariantAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\Variant\ProductVariantAttrCatType;

class ProductVariantAttrCat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name",
        "companie_id",
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

    public function attributes(){
        return $this->hasMany(ProductVariantAttribute::class);

    }

    public function cat_attribute_type(){
        return $this->belongsTo(ProductVariantAttrCatType::class, "attr_cat_type_id","id");
    }
}
