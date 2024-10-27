<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\ProductColorSize;

class ProductSize extends Model
{
    use SoftDeletes;
    protected $fillable = [

        "product_id",
        "name",
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_color_sizes(){
        return $this->hasMany(ProductColorSize::class);
    }
}
