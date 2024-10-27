<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companie;

class CompanieController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $companies= Companie::where('state_id',1)->get();

        return response()->json(["message" => 200 ,
        "companies" =>$companies->map(function($companie){
         return   [
                'id'=>$companie->id,
                'code'=>$companie->code,
                'name'=>$companie->name,
               // 'logo'=>$companie->logo,
                'logo'=>$companie->companie_path_url()."/logos/".$companie->logo,
                'slogan'=>$companie->slogan
         ];
        })
    ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {

        $companie= Companie::where('code',$code)->first();

        if(!$companie)
        {
            return response()->json(["message" => 402 , "companie" => null ]) ;
        }

        return response()->json(["message" => 200 , "companie" =>

        [
        'id'=>$companie->id,
        'code'=>$companie->code,
        'name'=>$companie->name,
       // 'logo'=>$companie->logo,
        'logo'=>$companie->companie_path_url()."/logos/".$companie->logo,
        'slogan'=>$companie->slogan
       ]

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
