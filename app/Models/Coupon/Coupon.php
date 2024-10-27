<?php

namespace App\Models\Coupon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Coupon\CouponProduct;
use App\Models\Coupon\CouponCategorie;
use App\Models\Coupon\CouponBrand;
use App\Models\Discount\DiscountType;
use App\Models\Discount\Campaign;
use App\Models\Discount\DiscountApply;
use App\Models\Discount\DiscountCountable;
use App\Models\Product\State;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable=[
        "code",
        "discount_type_id",
        "discount_apply_id",
        "discount_countable_id",
        "campaign_id",
        "discount",
        "num_use",
        "start_date",
        "end_date",
        "state_id",
        "companie_id"

    ];




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

    public function discount_apply()
    {
        return $this->belongsTo(DiscountApply::class );
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class );
    }

    public function discount_type()
    {
        return $this->belongsTo(DiscountType::class );
    }
    public function discount_countable()
    {
        return $this->belongsTo(DiscountCountable::class );
    }

    public function categories(){
        return $this->hasMany(CouponCategorie::class);
    }

    public function products(){
        return $this->hasMany(CouponProduct::class);
    }

    public function brands(){
        return $this->hasMany(CouponBrand::class);
    }


}
