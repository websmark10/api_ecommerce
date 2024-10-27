<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;

class InventoryType extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'created_by', 'updated_by', 'deleted_by'];

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

    public function products(){
        return $this->hasMany(Product::class);

    }
}
