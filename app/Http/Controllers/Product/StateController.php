<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\State;

class StateController extends Controller
{

    public function index(Request $request)
    {

        $states= State::orderBy("id","asc")->get();

        return response()->json([
            "states"=>$states
            ]);


    }

    public function states(Request $request)
    {

        $states= State::orderBy("id","asc")->get();

        return response()->json([
            "states"=>$states
            ]);


    }
}
