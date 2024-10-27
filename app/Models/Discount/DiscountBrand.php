<?php

namespace App\Models\Discount;

use Carbon\Carbon;
use App\Models\Product\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Discount\Discount;

class DiscountBrand extends Model
{
    use HasFactory;
  //  use SoftDeletes;
  protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

    protected $fillable = [
        "discount_id",
        "brand_id",
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

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function discount(){
        return $this->belongsTo(Discount::class);
    }

    public function brands(){

        return $this->hasMany(Brand::class);
    }
}
