<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;



class Currencie extends Model
{

   // use SoftDeletes;
    use Userstamps;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "code",
         "name",
         "exchange_rate",
         "symbol",
         "default",
         "companie_id",
         "store_id"
    ];



}
