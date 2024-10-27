<?php

namespace App\Models\Product;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\ProductColor;
use App\Models\Product\ProductSize;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColorSize extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "product_color_id",
        "product_size_id",
        "stock",
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

    public function product_color()
    {
        return $this->belongsTo(ProductColor::class);
    }
    public function product_size()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
