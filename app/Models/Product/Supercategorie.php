<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Categorie;
//use App\Models\Product\Product;
//use App\Models\Discount\DiscountCategorie;
use Wildside\Userstamps\Userstamps;
use App\Models\Product\Product;

class Supercategorie extends Model
{
     //use HasFactory;
    // protected $table="Product";
    // public $timestamps=false;

    use SoftDeletes;
    use Userstamps;
    protected $fillable=[
        "id",
        "code",
        "name",
        "description",
        "imagen",
        "icon",
        "state_id",
        "created_at",
        "updated_at",
        "deleted_at",
        "created_by",
        "updated_by",
        "deleted_by"

    ];


    public function scopeFilterAdvance($query, $companie_id,$state,$search){
        // if($super_category_id){
        //     $query->where('supercategorie_id',$super_category_id);
        // }

        if($companie_id){
            $query->where('companie_id', $companie_id);
        }

        if($state){
            $query->where('state',$state);
        }
        if($search){
            $query->where("name","like","%".$search."%");
        }
        return $query;

    }
    public function scopeFilterAdvanceNotExistence($query,$arraySearch){
        if($arraySearch){
           $query->whereIn('code',$arraySearch);
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



    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }


    public function product_supercategorie_firsts(){
        return $this->hasMany(Product::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
