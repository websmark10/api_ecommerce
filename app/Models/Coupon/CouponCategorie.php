<?php

namespace App\Models\Coupon;

use Carbon\Carbon;
use App\Models\Product\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponCategorie extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "coupon_id",
        "categorie_id",
         "companie_id"
    ];

    public function setCreatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"] = Carbon::now();
    }
    public function setUpdatedtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"] = Carbon::now();
    }

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
}
