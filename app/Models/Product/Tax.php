<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Product\TaxType;

class Tax extends Model
{
     //use HasFactory;
    // protected $table="Product";
    // public $timestamps=false;

    use SoftDeletes;
    protected $fillable=[
        'code',
        'rate',
        'tax_type_id',
        'store_id',
        'companie_id',
        'state_id'
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


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function tax_type()
    {
        return $this->belongsTo(TaxType::class);
    }

}
