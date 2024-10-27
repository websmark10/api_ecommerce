<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\ProductColorSize;
use App\Models\Product\Variant\ProductVariant;

class ProductVariantState extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "id",
        "code",
        "name",
        "state_id",
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

    // public function products(){
    //     return $this->hasMany(Product::class);
    // }

}
