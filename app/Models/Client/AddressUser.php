<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressUser extends Model
{

    use SoftDeletes;

    protected $fillable=[
         "user_id",
         "full_name",
         "full_surname",
         "company_name",
         "country_region",
         "street_number",
         "city",
         "zip_code",
         "phone",
         "email"
    ];

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

    public function user(){
        return $this->belongsTo(User::class);
    }


}
