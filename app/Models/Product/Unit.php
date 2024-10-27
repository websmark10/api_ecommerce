<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Unit extends Model
{
     //use HasFactory;
    // protected $table="Product";
    // public $timestamps=false;

    use SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

    protected $fillable=[
        "code",
        "name",
        "base_unit",
        "operator",
        "value",
        "state_id"
    ];

    public function scopeFilterAdvance($query,$state,$search){
        if($state){
            $query->where('state',$state);
        }
        if($search){
            $query->where("name","like","%".$search."%");
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





}
