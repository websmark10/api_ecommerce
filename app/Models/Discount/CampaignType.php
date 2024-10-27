<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Discount\DiscountProduct;
use App\Models\Discount\DiscountCategorie;

use App\Models\Discount\DiscountType;

use App\Models\Discount\DiscountApply;

class CampaignType extends Model
{
    use SoftDeletes;

    protected $fillable=[
        "code",
        "state_id"

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
   
}
