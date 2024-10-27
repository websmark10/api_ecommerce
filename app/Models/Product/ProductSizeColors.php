<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Product;
use App\Models\Product\ProductColorSize;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSizeColors extends Model
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

    public function product_size_colors()
    {
        return $this->hasMany(ProductColorSize::class);
    }
}
