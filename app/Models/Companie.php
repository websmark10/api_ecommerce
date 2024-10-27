<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use App\Models\Setting\Setting;
use App\Models\Setting\Currencie;

class Companie extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

    protected $fillable=[
        'id', 'code','name', 'logo', 'slogan', 'description', 'state_id'
    ];



    protected $appends = ['folder_companie'];

    public function getFolderCompanieAttribute()
    {
        return str_pad($this->id,4, "0", STR_PAD_LEFT)."_".  $this->code ;
        ;
    }

   public function setting(){
        return $this->belongsTo(Setting::class);
   }

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set("America/Mexico_City");
        $this->attributes["created_at"] = Carbon::now();
        $this->attributes["created_at"] =  "HOLITA";
    }

    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set("America/Mexico_City");
        $this->attributes["updated_at"] = Carbon::now();
    }

    public function settings(){
        return $this->hasMany(Setting::class);
    }

    public function  companie_folder()
    {
       return  str_pad($this->id, 4, "0", STR_PAD_LEFT)."_".$this->code ;
    }

    public function companie_path_url()
    {
       return  env("APP_URL")."/storage/companies/".$this->companie_folder();
    }

    public function companie_path_public()
    {
    return  public_path("storage")."\\companies\\".$this->companie_folder();

    }


    public function currencie(){


        foreach ($this->settings as $key => $set) {
          if($set->key=="currencie_id")
          {
            $currencie= Currencie::where('id', $set->id)-> first();
            return $currencie;
          }
        }
        return null;
    }
}
