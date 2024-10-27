<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Store;
use App\Models\User;
//use Illuminate\Database\Eloquent\Relations\Pivot;

class StoreUser extends Model
{

        use SoftDeletes;
        use Userstamps;

    protected $fillable = [
    'id',
    'store_id',
    'user_id'
    ];

    // public function store(){
    //     return $this->belongsTo(Store::class);
    //  }
    //  public function user(){
    //     return $this->belongsTo(User::class);
    //  }


    //  public function stores(){
    //     return $this->belongsToMany(Store::class);
    //  }
    //  public function users(){
    //     return $this->belongsToMany(User::class);
    //  }


}
