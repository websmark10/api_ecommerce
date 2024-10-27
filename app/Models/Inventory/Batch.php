<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;

class Batch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "id",
        "file_name",
        "batch_type_id",
        "companie_id",
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


}
