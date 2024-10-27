<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Product;
use App\Models\Sale\SaleDetail;
use App\Models\User;

class Review extends Model
{
    protected $fillable=[
        'product_id',
         'user_id',
         'sale_detail_id',
         'message',
         'rating'
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

    public function product(){
         return  $this->belongsTo(Product::class);
    }


    public function user(){
        return  $this->belongsTo(User::class);
   }


   public function sale_detail(){
    return  $this->belongsTo(SaleDetail::class);
   }


}
