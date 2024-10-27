<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;
use App\Models\Inventory\Batch;
use App\Models\Companie;
use App\Models\Product\Variant\ProductVariant;


class Inventory  extends Model
{
    use SoftDeletes;

    public $table = 'inventory';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

    protected $fillable = [
        "batch_id",
        "product_id",
        "product_variant_id",
        "inventory_source_id",
        "store_id",
        "provider_id",
        "stock",
        "manufactured_date",
        "expiry_date",
        "price",
        "cost",
        "available",
      "companie_id",    ];

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

    public function batch(){
        return $this->belongsTo(Batch::class);

    }
    public function product(){
        return $this->belongsTo(Product::class);

    }

    public function product_variant(){
        return "iiiiiiii";
       // return $this->belongsTo(ProductVariant::class);

    }

    public function products(){
        return $this->hasMany(Product::class);

    }

    public function companie(){
        return $this->belongsTo(Companie::class);

    }

}
