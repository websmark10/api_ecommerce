<?php

namespace App\Models\Product;

use Carbon\Carbon;
use App\Models\Sale\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Discount\DiscountProduct;
use App\Models\Discount\DiscountCategorie;
use App\Models\Product\Supercategorie;
use App\Models\Product\Categorie;
use App\Models\Product\Brand;
use App\Models\Product\Unit;
use App\Models\Product\Tax;
use App\Models\Product\Subcategorie;
use App\Models\Product\ProductImage;
use App\Models\Product\ProductSize;
use App\Models\Product\ProductState;
use App\Models\Product\State;
use App\Models\Inventory\InventoryType;
use App\Models\Discount\DiscountType;
use Wildside\Userstamps\Userstamps;
use App\Models\User;
use App\Models\Product\Variant\ProductVariantDimension;
use App\Models\Product\Variant\ProductVariantAttribute;
use App\Models\Product\Variant\ProductVariant;

use App\Models\Product\Variant\ProductVariantState;
use App\Models\Companie;

use Illuminate\Support\Facades\File;
use App\Models\Discount\DiscountSubcategorie;
use App\Models\Discount\DiscountBrand;
use App\Models\Discount\Discount;
use App\Models\Product\ProductSpecification;

class Product extends Model
{
   // use HasFactory;
//    use SoftDeletes;
   use Userstamps;
   //public $timestamps = false;
   protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

   protected $fillable = [
        "id",
        "subcategorie_id",
        "brand_id",
        "unit_id",
        "tax_id",
        "title",
        "slug",
        "sku",
        "tags",
        "description",
        "summary",
        "cover",
        "online",
        "companie_id",
        "state_id",
        "inventory_type_id",

        // "created_at",
        // "updated_at",
        // "deleted_at",
        // "created_by",
        // "updated_by",
        // "deleted_by",
    ];

    protected $withCount = ['reviews'];

    public function user_created()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function user_updated()
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }

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


   public function discount_products() {
        return $this->hasMany(DiscountProduct::class);
    }

    public function discount_brands() {
        return $this->hasMany(DiscountBrand::class,"brand_id");

    }




    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function companie()
    {
        return $this->belongsTo(Companie::class);
    }

    public function  companie_folder()
    {
       return  str_pad($this->companie_id, 4, "0", STR_PAD_LEFT)."_".$this->companie->code ;
    }

    public function companie_path_url()
    {
       return  env("APP_URL")."/storage/companies/".$this->companie_folder();
    }

    public function companie_path_public()
    {
    return  public_path("storage")."\\companies\\".$this->companie_folder();

    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }




    public function subcategorie()
    {
        return $this->belongsTo(Subcategorie::class);
    }


    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function inventory_type()
    {
        return $this->belongsTo(InventoryType::class);
    }

    public function variants()
    {
        //return $this->hasMany(ProductImage::class);
        return $this->hasMany(ProductVariant::class);
    }

    //NO SIRVIO RELACION public function discounts(){
    //     return $this->hasManyThrough(Discount::class, DiscountProduct ::class);
    // }

    public function variant_individual() //When is Individual onli
    {

         $response=NULL;
        date_default_timezone_set("America/Mexico_City");
      // return $this->discount_product_variants;

       if(  $this->inventory_type->code=="INDIVIDUAL" )
      // if(  $this->inventory_type_id==1 )
        foreach ($this->variants as $key => $variant) {

         return   $response=$variant;

        }
        return $response;

    }
    public function variant_cover3() //When is Individual onli
    {

       return ( $this->variants()->where('cover',1)->first() )?:null;

    }

   /*  public function product_variant() //When is Individual onli
    {

     // return $this->hasMany(ProductVariant::class)->where('cover',1)->where('deleted_at',null)->first() ;
return "ppppppppppp";
     return $this->hasMany(ProductVariant::class)->where('cover',1)->where('deleted_at',null) ;

    }*/

    public function variant_cover() //When is Individual onli
    {



     return $this->hasOne(ProductVariant::class)->where('cover',1)->where('deleted_at',null);

/*
       $response=NULL;
       foreach ($this->variants as $key => $var) {
           if($var->cover==1 && $var->deleted_at==null)
           {
                  $response=$var;
           }
       }
       return $response;

       */
/*
        return $this->variants->with(['inventory' => function( $query){
            //$query->select('name');
            $query->where("cover",1)->where("deleted_at",null);
            $query->limit(1);

        }])->get();
*/
    }


    public function variant(int $id ) //When is Individual onli
    {

      // return ( $this->variants()->where('cover',1)->first() )?:null;

       $response=NULL;

       foreach ($this->variants as $key => $var) {

           if($var->id== $id)
           {

                  $response=$var;


           }
       }
       return $response;

    }


    public function image_cover()
    {
        $variantCover=$this->variant_cover ;
    //      return response()->json([ "XXX" =>
    //    //  $this->companie_path_public()  .'\\products\\'.      $variantCover->image
    //     // $this->companie_path_public()
    //        $variantCover->image
    //      ]);

        if($this->inventory_type->code=='MULTIPLE')
  return    (  file_exists( $this->companie_path_public()  .'\\products\\'. $this->id.'\\variants\\'.   $variantCover->id. "\\".   $variantCover->image ))?
             [
                "url"=> $this->companie_path_url()."/products/". $this->id. "/variants/".   $variantCover->id.  "/".   $variantCover->image ,
                "name"=>    $variantCover->image,
                "size"=>  (string)filesize( $this->companie_path_public() ."\\products\\". $this->id."\\variants\\" .  $variantCover->id.  "\\".  $variantCover->image ),

          ]:
          [
          "url"=> $this->companie_path_url() ."/products/" . "noimage.png",
          "name"=>   $variantCover->image,
          "size"=> (string) filesize( $this->companie_path_public() ."\\products\\" . "noimage.png")
          ] ;
         else if($this->inventory_type->code=='INDIVIDUAL')

   return      (  file_exists( $this->companie_path_public()  .'\\products\\'.      $variantCover->image ))?
         [

                "url"=> $this->companie_path_url()."/products/".   $variantCover->image ,
                "name"=>    $variantCover->image,
                 "size"=>  (string)filesize( $this->companie_path_public() ."\\products\\" . $variantCover->image )
         ]:
         [
         "url"=> $this->companie_path_url() ."/products/" . "noimage.png",
         "name"=>   $variantCover->image,
         "size"=> (string) filesize( $this->companie_path_public() ."\\products\\" . "noimage.png")
         ] ;
         else{
            return null;
         }


    }

    public function image_url_cover()
    {
        $variantCover=$this->variant_cover() ;


        if($this->inventory_type->code=='MULTIPLE')
  return    (  file_exists( $this->companie_path_public()  .'\\products\\'. $this->id.'\\variants\\'.   $variantCover->id. "\\".   $variantCover->image ))?
             [
                "url"=> $this->companie_path_url()."/products/". $this->id. "/variants/".   $variantCover->id.  "/".   $variantCover->image ,

          ]:
          [
          "url"=> $this->companie_path_url() ."/products/" . "noimage.png",
               ] ;
         else if($this->inventory_type->code=='INDIVIDUAL')

   return      (  file_exists( $this->companie_path_public()  .'\\products\\'.      $variantCover->image ))?
         [

                "url"=> $this->companie_path_url()."/products/".   $variantCover->image ,
          ]:
         [
         "url"=> $this->companie_path_url() ."/products/" . "noimage.png",
              ] ;
         else{
            return null;
         }


    }


/*
    public function images_variants()
    {
        $variantCover=$this->variant_cover() ;


        if($this->inventory_type->code=='MULTIPLE')
  return    (  file_exists( $this->companie_path_public()  .'\\products\\'. $this->id.'\\variants\\'.   $variantCover->id. "\\".   $variantCover->image ))?
             [

                "images_variants"=>

                    $this->variants->map(function($img){
                        return         (file_exists($this->companie_path_public() ."\\products\\". $this->id."\\variants\\" . $img->id.  "\\".  $img->image))?
                   [
                    "url"=> $this->companie_path_url()."/products/". $this->id. "/variants/".  $img->id.  "/".  $img->image ,
                    "name"=>   $img->image,
                    "size"=>  (string)filesize( $this->companie_path_public() ."\\products\\". $this->id."\\variants\\" . $img->id.  "\\".  $img->image ),
                    "cover"=> $img->cover
                        ]:
                        [
                            "url"=> $this->companie_path_url() ."/products/" . "noimage.png",
                            "name"=>   $variantCover->image,
                            "size"=> (string) filesize( $this->companie_path_public() ."\\products\\" . "noimage.png")
                            ] ;
                        ;
                    })
          ]:
          [
          "url"=> $this->companie_path_url() ."/products/" . "noimage.png",
          "name"=>   $variantCover->image,
          "size"=> (string) filesize( $this->companie_path_public() ."\\products\\" . "noimage.png")
          ] ;

         else{
            return null;
         }


    }
*/

public function dimensions()
{
    return $this->belongsToMany(ProductVariantDimension::class, ProductVariant::class, "product_id" ,"product_variant_dimension_id");
}

public function attributes()
{
    return $this->belongsToMany(ProductVariantAttribute::class, ProductVariant::class, "product_id" ,"product_variant_attribute_id");
}




    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    // public function discount_type()
    // {
    //     return $this->hasMany(DiscountType::class);
    // }
    // public function discount_products()
    // {
    //     return $this->hasMany(DiscountProduct::class);
    // }

    // public function discount_product_variants()
    // {
    //     return $this->hasMany(DiscountVariant::class);
    // }

    // public function discounts_categories()
    // {
    //     return $this->hasMany(DiscountCategorie::class);
    // }


    public function getAvgRatingAttribute()
    {
        return $this->reviews->avg("rating");
    }



    public function getDiscount()
    {

        $response=NULL;
        date_default_timezone_set("America/Mexico_City");
        foreach ($this->discounts_variant as $key => $disc_variant) {
           foreach ($this->disc_variant->discounts as $key => $discount) {

            if($discount->state_id==1)
            {
                if(Carbon::now()->between($discount->start_date,$discount->discount->end_date)>orderBy('id' , 'desc'))
                {
                    $response= $discount->discount;
                    break;
                }
            }
           }
        }
        return  $response ;

    }



    public function scopefilterProduct($query,$companie_id,$supercategorie_id , $categorie_id , $subcategorie_id, $brand_id, $unit_id,$state_id, $search)
    {
        if($subcategorie_id){
            $query->where("subcategorie_id",$subcategorie_id );
        }else  if($categorie_id){
            $query->whereHas("subcategorie",function($q1) use($categorie_id){
                $q1->where("categorie_id", $categorie_id );
           });
        }else  if($supercategorie_id){
            $query->whereHas("subcategorie",function($q1) use($supercategorie_id){
                $q1->whereHas("categorie",function($q2) use($supercategorie_id){
                    $q2->where("supercategorie_id", $supercategorie_id );
                });
            });
        }

        // if($supercategorie_id){
        //     $query->where("supercategorie_id",$supercategorie_id );
        // }

        // if($categorie_id){
        //     $query->where("categorie_id",$categorie_id );
        // }

        // if($subcategorie_id){
        //     $query->where("subcategorie_id",$subcategorie_id );
        // }


        if($companie_id){
            $query->where("companie_id",$companie_id );
        }

        if($brand_id){
            $query->where("brand_id",$brand_id );
        }

        if($unit_id){
            $query->where("unit_id",$unit_id );
        }
        if($state_id){
            $query->where("state_id",$state_id );
        }


        if($search){
            $query->where("title","like","%".$search."%")
                   -> orWhereHas("variants",function($q2) use($search){
                                        $q2->where("sku","like","%".$search."%");
                                    });
        }



        return $query;
    }

    public function scopefilterAdvance($query,$categories,$review,$min_price , $max_price, $dimension_id, $attribute_id,$search_product)
    {
        if( $categories && sizeOf($categories)>0){
            $query->whereIn("categorie_id", $categories);

        }

        if($review){
            $query->whereHas("reviews",function($q) use($review){
                $q->where("rating", $review );
            });
        }
        if($min_price>0 && $max_price>0)
        {
            $query->whereBetween("price",[$min_price,$max_price]);
        }
 /*
        if($size_id){
            $query->whereHas("sizes",function($q) use($size_id) {
                  $q->where("name","like","%".$size_id."%");
            });
       }

       if($color_id)
       {
        $query->whereHas("sizes",function($q1) use($color_id){
            $q1->whereHas("product_color_sizes",function($q2) use($color_id){
                $q2->where("product_color_id", $color_id );
            });
        });
       }
       */

    if($search_product){
        $query->where("title","like","%".$search_product."%");
    }
    return $query;

    }



      // discount_categorie
      public function getDiscountCategorieAttribute() {
        date_default_timezone_set("America/Lima");
        $discount = null;
        foreach ($this->subcategorie->categorie->discount_categories as $key => $discount_categorie) {
            if($discount_categorie->discount &&
            //$discount_categorie->discount->discount_type_id == 1 &&
            $discount_categorie->discount->state_id == 1){
                // [24-01-2024, 25  ,27-01-2024]
                if(Carbon::now()->between($discount_categorie->discount->start_date,Carbon::parse(
                    $discount_categorie->discount->end_date)->addDays(1))){
                    $discount = $discount_categorie->discount;
                    break;
                }
            }
        }
        return $discount;
    }



    public function getDiscountProductAttribute() {
        date_default_timezone_set("America/Lima");
        $discount = null;
        foreach ($this->discount_products as $key => $discount_product) {
            if($discount_product->discount &&
            // $discount_product->discount->discount_type_id == 1 &&
            $discount_product->discount->state_id == 1){
                // [24-01-2024, 25  ,27-01-2024]
                if(Carbon::now()->between($discount_product->discount->start_date,Carbon::parse(
                    $discount_product->discount->end_date)->addDays(1))){
                    $discount = $discount_product->discount;
                    break;
                }
            }
        }
        return $discount;
    }

    public function getDiscountBrandAttribute() {
        date_default_timezone_set("America/Lima");
        $discount = null;
        foreach ($this->brand->discount_brands as $key => $discount_brand) {
            if($discount_brand->discount &&
            // $discount_brand->discount->discount_type_id == 1 &&
            $discount_brand->discount->state_id == 1){
                // [24-01-2024, 25  ,27-01-2024]
                if(Carbon::now()->between($discount_brand->discount->start_date,Carbon::parse(
                    $discount_brand->discount->end_date)->addDays(1))){
                    $discount = $discount_brand->discount;
                    break;
                }
            }
        }
        return $discount;
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

}
