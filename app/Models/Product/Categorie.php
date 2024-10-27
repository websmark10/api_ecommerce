<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Product;
use App\Models\Product\Supercategorie;
use App\Models\Product\Subcategorie;
use App\Models\Discount\DiscountCategorie;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Facades\DB;
use App\Models\Companie;

class Categorie extends Model
{
     //use HasFactory;
    // protected $table="Product";
    // public $timestamps=false;

    use SoftDeletes;
    use Userstamps;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];


    protected $fillable=[
        "id",
        "supercategorie_id",
        "code",
        "name",
        "description",
        "imagen",
        "icono",
        "state_id",
        "created_at",
        "updated_at",
        "deleted_at",
        "created_by",
        "updated_by",
        "deleted_by"
    ];

    public function scopeFilterAdvance($query, $supercategorie_id,$state,$search){
        if($supercategorie_id){
            $query->where('supercategorie_id',$supercategorie_id);
        }
        if($state){
            $query->where('state',$state);
        }
        if($search){
            $query->where("name","like","%".$search."%");
        }
        return $query;

    }
    public function scopefilterCategorie($query,$companie_id,$state_id, $search)
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


    public function scopeFilterAdvanceNotExistence($query,$arraySearch){
        if($arraySearch){
           $query->whereIn('code',$arraySearch);
        }
        return $query;
    }

    public function companie()
    {
        return $this->belongsTo(Companie::class);
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

    public function supercategorie()
    {
        return $this->belongsTo(Supercategorie::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategorie::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class,Subcategorie::class);
    }



//No Funciona

    public function discount_categories()
    {
        return $this->hasMany(DiscountCategorie::class,'categorie_id');
    }




    public function state()
    {
        return $this->belongsTo(State::class);
    }



}
