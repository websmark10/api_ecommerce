<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Role;
use App\Models\Client\AddressUser;
use Illuminate\Support\Facades\Hash;
use App\Models\StoreUser;
use App\Models\People\Store;
use App\Models\Companie;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'surname',
        'email',
        'email_verified_at',
        'code_verified',
        'password',
        'user_type_id',
        'role_id',
        'birthday',
        'gender_id',
        'companie_id',
        'state_id',
        'avatar',
        'logo',
        'phone',
        'unique_id'
      //  'remember_token'
    ];

    //protected $hidden=["password","remember_token"];

    //protected $casts=["email_verified_at"=>'datetime'];
    // public function storeUsers(){
    //     return $this->hasMany(StoreUser::class);
    //  }



    public function companie(){
          return $this->belongsTo(Companie::class);
       }

  public function companie_folder(){
    return   str_pad($this->id, 4, "0", STR_PAD_LEFT)."_".$this->companie->code ;
    }

    public function companie_path_public()
    {
    return  public_path("storage")."\\companies\\". $this->companie_folder();

    }

    public function companie_path_url()
    {
       return  env("APP_URL")."/storage/companies/".$this->companie_folder();
    }

    public function stores(){
      //  return $this->hasMany(Store::class);
    //  return $this->belongsToMany(Store::class,'store_user','store_id','user_id');
    return $this->belongsToMany(Store::class);
     }

     public function address(){
        return $this->hasMany(AddressUser::class);
     }

    public function scopeFilterAdvance($query,$state,$search){
        if($state){
            $query->where('state',$state);
        }
        if($search){
            $query->where("name","like","%".$search."%")->orWhere("surname","like","%".$search."%")->orWhere("email","like","%".$search."%");
        }
        return $query;

    }

        public function setPasswordAttribute($password){
             if($password){


               $this->attributes["password"]=bcrypt($password);

           // $this->attributes["password"]=Hash::make($password);

             }
        }

    public function role(){
        return $this->belongsTo(Role::class);
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
