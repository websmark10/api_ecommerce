<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product\Product;
use App\Models\Product\ProductSize;
use App\Models\Product\ProductColorSize;
use App\Models\Product\Variant\ProductVariant;
use App\Models\Product\Variant\ProductVariantDimension;
use App\Models\Product\Variant\ProductVariantAttribute;
use App\Models\Setting\Currencie;
use App\Models\Discount\Discount;


class Cart extends Model
{
   //   use HasFactory;
   protected $fillable=[
   "user_id",
   "product_variant_id",
//    "campaing_id",
//    "discount_type_id",
//    "discount_apply_id",
//    "discount_method_id",
   "discount_id",
   "discounted",
   "quantity",
   "product_variant_dimension_id",
   "product_variant_attribute_id",
   "code_coupon",
   "code_discount",
   "price_unit",
   "price_net",
   "price_unit_currencie",
   "price_net_currencie",
   "exchange_rate",
   "exchange_rate_currencie",
   "subtotal",
   "total",
   "currencie_id"
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

   public function client(){
       return $this->belongsTo(User::class,"user_id");
   }

   public function user(){
    return $this->belongsTo(User::class);
}

public function currencie(){
    return $this->belongsTo(Currencie::class);
}

public function discount(){
    return $this->belongsTo(Discount::class);
   }

   public function product(){
    return $this->belongsTo(Product::class);
   }


   public function product_variant(){
    return $this->belongsTo(ProductVariant::class);
   }



//    public function product_variant_dimension(){
//     return $this->belongsTo(ProductVariantDimension::class);
//    }


//    public function product_variant_attribute(){
//     return $this->belongsTo(ProductVariantAttribute::class);
//    }




}

