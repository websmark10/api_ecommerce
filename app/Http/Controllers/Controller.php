<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $user;


    public function __construct()
    {
         $user=Auth::user();
        $this->user = $user;
      //  $this->folderCompanie = str_pad($user->id,4, "0", STR_PAD_LEFT)."_".  $user->companie->code ;

        View::share(['user'=> $this->user]);
    }

}
