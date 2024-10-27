<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\Product;
use App\Models\Product\Subcategorie;
use App\Models\Product\Supercategorie;
use App\Models\Product\Categorie;
use App\Models\Discount\DiscountSubcategorie;
 use Wildside\Userstamps\Userstamps;

class Subcategorie extends Model
{
     //use HasFactory;
    // protected $table="Product";
    // public $timestamps=false;

    use SoftDeletes;
    use Userstamps;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

    protected $fillable=[
        "categorie_id",
        "code",
        "name",
        "description",
        "imagen",
        "state_id",
        // "created_at",
        // "updated_at",
        // "deleted_at",
        // "created_by",
        // "updated_by",
        // "deleted_by"

    ];

    public function scopeFilterAdvance($query,$categorie_id, $state,$search){
        if($categorie_id){
            $query->where('categorie_id',$categorie_id);
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }



    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function discount_subcategories()
    {
        return $this->hasMany(DiscountSubcategorie::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
