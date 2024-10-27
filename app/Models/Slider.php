<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\State;
use App\Models\SliderType;
use App\Models\Companie;

class Slider extends Model
{
    protected $fillable=[
        "title",
        "subtitle",
        "label",
        "imagen",
        "link",
        "state_id",
        "color",
        "companie_id"
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
    public function slider_type()
    {
        return $this->belongsTo(SliderType::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function companie()
    {
        return $this->belongsTo(Companie::class);
    }
}
