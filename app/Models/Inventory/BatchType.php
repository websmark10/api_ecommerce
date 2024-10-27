<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Inventory;

class BatchType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "id",
        "code",
        "state_id",
    ];

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

    public function inventories(){
        return $this->hasMany(Inventory::class);

    }
}
