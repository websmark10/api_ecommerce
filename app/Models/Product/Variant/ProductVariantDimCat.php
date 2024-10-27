<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantDimCat extends Model
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

    public function product_variant_dimensions(){
        return $this->hasMany(ProductVariantDimensions::class);

    }
}
