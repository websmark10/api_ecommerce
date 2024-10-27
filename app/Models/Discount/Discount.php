<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Discount\DiscountProduct;
use App\Models\Discount\DiscountCategorie;

use App\Models\Discount\DiscountType;

use App\Models\Discount\DiscountApply;
use App\Models\Discount\Campaign;
use App\Models\Discount\DiscountBrand;
use App\Models\Discount\CampaignType;
use App\Models\Discount\DiscountMethod;
use App\Models\Product\State;
use App\Models\Product\Product;
use App\Models\Product\Brand;
use App\Models\Product\Categorie;

class Discount extends Model
{
    use HasFactory;
   //  use SoftDeletes;
   protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];


    protected $fillable=[
        "code",
        "discount_apply_id",
        "discount_type_id",
        "discount_method_id",
        "campaign_id",
        "discount",
        "state_id",
        "start_date",
        "end_date",
        // "created_at",
        // "updated_at  ",
        // "deleted_at ",
        "companie_id",
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


    public function scopefilter($query,$companie_id,$state_id,$start_date,$end_date, $search)
    {

        if($companie_id){
            $query->where("companie_id",$companie_id );
        }

        if($start_date){
            $query->whereDate("start_date" ,">=" ,$start_date  );
          //  $query->whereDate('created_at', '>=', date('Y-m-d').' 00:00:00'));
        }

        if($end_date){
            $query->whereDate("end_date","<=",$end_date  );

        }
        if($state_id){
            $query->where("state_id",$state_id );
        }


        if($search){
            $query->where("code","like","%".$search."%")
            -> orWhereHas("campaign",function($q2) use($search){
                $q2->where("name","like","%".$search."%");
            });

        }



        return $query;
    }


    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function discount_type()
    {
        return $this->belongsTo(DiscountType::class);
    }

    public function discount_apply()
    {
        return $this->belongsTo(DiscountApply::class );
    }

    public function discount_method()
    {
        return $this->belongsTo(DiscountMethod::class );
    }


    public function campaign()
    {
        return $this->belongsTo(Campaign::class );
    }


    public function products() {
        return $this->belongsToMany(Product::class,'discount_products');
    }
     public function categories(){
        return $this->belongsToMany(Categorie::class,'discount_categories');
    }
    public function brands(){
        return $this->belongsToMany(Brand::class,'discount_brands');
    }


    public function discount_products() {
        return $this->hasMany(DiscountProduct::class,'discount_id');
    }
     public function discount_categories(){
        return $this->hasMany(DiscountCategorie::class,'discount_id');
    }
    public function discount_brands(){
        return $this->hasMany(DiscountBrand::class,'discount_id');
    }





    public function scopeValidateDiscount($query,$request,$product_array=[],$categorie_array=[])
    {
        $query->where("type",$request->type);
        if($request->type == 1){ //FILTRAR POR PRODUCTO
            $query->whereHas("products",function($q) use($product_array){
                return $q->whereIn("product_id",$product_array);
            });
        }
        if($request->type == 2){//FILTRAR POR CATEGORIA
            $query->whereHas("categories",function($q) use($categorie_array){
                return $q->whereIn("categorie_id",$categorie_array);
            });
        }
        return $query;
    }




}
