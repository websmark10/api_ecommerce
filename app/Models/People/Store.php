<?php

namespace App\Models\People;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Companie;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\People\Store;
use App\Models\User;
use App\Models\StoreUser;

class Store extends Model
{
    use SoftDeletes;
    use Userstamps;

    protected $fillable=[
        'id',
        'name',
        'address',
        'phone',
        'whatsapp',
        'url_lan_printer',
        'url_printer',
        'country_id',
        'google_maps',
        'companie_id',
        'state_id',
        'main',
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

    public function storeUsers(){
        return $this->hasMany(StoreUser::class);
     }
    public function users(){
       // return $this->hasMany(User::class);
       return $this->belongsToMany(User::class);
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

    public function companie()
    {
        return $this->belongsTo(Companie::class);
    }


}
