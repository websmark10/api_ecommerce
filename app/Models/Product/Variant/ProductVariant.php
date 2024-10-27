<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\Variant\ProductVariantDimension;
use App\Models\Product\Variant\ProductVariantAttribute;
use App\Models\Inventory\Inventory;
use App\Models\Product\Product;
use Carbon\Carbon;
use App\Models\Product\Variant\ProductVariantState;
use App\Models\Product\Variant\ProductVariant;
use App\Models\Product\Variant\ProductVariantImage;
use App\Models\Companie;

class ProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];


    protected $fillable = [
        'product_variant_attribute_id',
        'product_variant_dimension_id',
        'product_variant_state_id',
        'product_id',
        'cover',
        'online',
        'sku',
        'minimum_quantity',
        'image',

    ];



    public function product(){
        return   $this->belongsTo(Product::class);
       }

   public function product_variant_attribute(){
    return $this->belongsTo(ProductVariantAttribute::class);
   }

   public function product_variant_state(){
    return $this->belongsTo(ProductVariantState::class);
   }


   public function product_variant_dimension(){
    return $this->belongsTo(ProductVariantDimension::class);
   }

 

    public function product_imagen(){


        if($this->product->inventory_type->code=='MULTIPLE')
  return    (  file_exists( $this->product->companie_path_public()  .'\\products\\'. $this->product->id.'\\variants\\'.   $this->id. "\\".   $this->image ))?
             [
                "url"=> $this->product->companie_path_url()."/products/". $this->product->id. "/variants/".   $this->id.  "/".   $this->image ,
                "name"=>    $this->image,
                "size"=>  (string)filesize( $this->product->companie_path_public() ."\\products\\". $this->product->id."\\variants\\" .  $this->id.  "\\".  $this->image ),

          ]:
          [
          "url"=> $this->product->companie_path_url() ."/products/" . "noimage.png",
          "name"=>   $this->image,
          "size"=> (string) filesize( $this->product->companie_path_public() ."\\products\\" . "noimage.png")
          ] ;
         else if($this->product->inventory_type->code=='INDIVIDUAL')

   return      (  file_exists( $this->product->companie_path_public()  .'\\products\\'.   "\\".   $this->image ))?
         [

                "url"=> $this->product->companie_path_url()."/products/".   $this->image ,
                "name"=>    $this->image,
                 "size"=>  (string)filesize( $this->product->companie_path_public() ."\\products\\" . $this->image )
         ]:
         [
         "url"=> $this->product->companie_path_url() ."/products/" . "noimage.png",
         "name"=>   $this->image,
         "size"=> (string) filesize( $this->product->companie_path_public() ."\\products\\" . "noimage.png")
         ] ;
         else{
            return null;
         }

    }



    public function product_variant_images(){

        return $this->hasMany(ProductVariantImage::class);

    }


    public function inventory() //When is Individual onli
    {
       // return $this->hasMany(Inventory::class)->where('available',">",0)->orderBy('expiry_date', 'asc')->limit(1);
        return $this->hasOne(Inventory::class)->where("available",">","0")->orderBy('expiry_date', 'asc');
        //->where('available',">",0)->orderBy('expiry_date', 'asc')->limit(1);

 /*
       $inventory= $this->inventories->where('available',">",0)-> sortByDesc("expiry_date")->first();
       return  ($inventory)? $inventory:null;
*/

    }

    public function inventories()
    {

        return $this->hasMany(Inventory::class);
    }

/*
    public function inventory() //When is Individual onli
    {

      // return ( $this->variants()->where('cover',1)->first() )?:null;

       $response=NULL;

       foreach ($this->inventories as $key => $var) {
          // return $discount;
        //return   $response=$discount->discount;
           // break;
           if($var->cover==1)
           {

                  $response=$var;


           }
       }
       return $response;

    } */







    public function getDiscountVariantAttribute()
    {
        return null;
         $response=NULL;
        date_default_timezone_set("America/Mexico_City");
      // return $this->discount_product_variants;
        foreach ($this->discount_variants as $key => $discount) {
          // return $discount;
         //return   $response=$discount->discount;
            // break;
            if($discount->discount->state_id==1)
            {
                if(Carbon::now()->between($discount->discount->start_date,$discount->discount->end_date))
                {
                   $response= $discount->discount;

                    break;
                }
            }
        }
        return $response;

    }

}
