<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Discount\Discount;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountProduct extends Model
{
    use HasFactory;
  //  use SoftDeletes;
  protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

    protected $fillable=[
        "discount_id",
        "product_id",
         "companie_id"
    ];



    public function setCreatedAtAttribute($value)
    {
    	date_default_timezone_set("America/Mexico_City");
        $this->attributes["created_at"]= Carbon::now();
    }
    public function setUpdatedAtAttribute($value)
    {
    	date_default_timezone_set("America/Mexico_City");
        $this->attributes["updated_at"]= Carbon::now();
    }


    public function discount(){

         return $this->belongsTo(Discount::class);
    }

    public function product(){

        return $this->belongsTo(Product::class);
   }

   public function products(){

    return $this->hasMany(Product::class);
}



}
