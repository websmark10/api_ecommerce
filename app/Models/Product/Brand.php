<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Product;
use App\Models\Product\State;
use Wildside\Userstamps\Userstamps;
use App\Models\Discount\DiscountBrand;
use App\Models\Companie;
use Illuminate\Support\Facades\File;
class Brand extends Model
{
     //use HasFactory;
    // protected $table="Product";
    // public $timestamps=false;

    use SoftDeletes;
    use Userstamps;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

    protected $fillable=[
        "id",
        "code",
        "name",
        "description",
        "imagen",
        "state_id",
        "created_at",
        "updated_at",
        "deleted_at",
        "created_by",
        "updated_by",
        "deleted_by"
      ];

    public function scopeFilterAdvance($query,$state_id,$search){
        if($state_id){
            $query->where('state_id',$state_id);
        }
        if($search){
            $query->where("name","like","%".$search."%")->orWhere("code", $search);;
        }
        return $query;

    }

    public function scopefilterBrand($query,$companie_id,$state_id, $search)
    {
        if($companie_id){
            $query->where("companie_id",$companie_id );
        }

        if($state_id){
            $query->where("state_id",$state_id );
        }
        if($search){
            $query->where("name","like","%".$search."%")->orWhere("code", $search);;
        }
        return $query;
    }


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

    public function companie()
    {
        return $this->belongsTo(Companie::class);
    }


    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function discount_brands() {
        return $this->hasMany(DiscountBrand::class,"brand_id");
    }


    public function imagen()
    {

     return    (  file_exists( $this->imagen!="" && $this->companie->companie_path_public()  .'\\brands\\'.      $this->imagen ))?
         [

                "url"=> $this->companie->companie_path_url()."/brands/".   $this->imagen ,
                "name"=>    $this->imagen,
                 "size"=>  (string)filesize( $this->companie->companie_path_public() ."\\brands\\" . $this->imagen )
         ]:
         [
         "url"=> $this->companie->companie_path_url() ."/brands/" . "noimage.png",
         "name"=>   $this->imagen,
         "size"=> (string) filesize( $this->companie->companie_path_public() ."\\brands\\" . "noimage.png")
         ] ;

    }



}
