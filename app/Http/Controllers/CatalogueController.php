<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Product\SuperCategorieCollection;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Product\SuperCategorieResource;
use App\Models\Product\State;
use App\Models\Product\Supercategorie;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  public function __construct()
    //  {
    //      $this->middleware('auth:api');
    //  }

     public function test(){
        return "Funciona ruta productos/subcategorias test";
     }


    public function index(Request $request)
    {
        $arraySearch=explode(',',$request->get('params'));

         //return response()->json(["supercategories" =>  $arraySearch
      // $brands=Brand::filterAdvance( $state_id,$search)->with(['creator','editor','destroyer'])->orderBy("id","desc")->paginate($pageSize);
       // ]);
       return response()->json([
        //   ($request->supercategories)?? "supercategories" => SuperCategorieResource::make(SuperCategorie::orderBy("id","desc")->get()),  //No hago referencia a collection porque es un solo producto
            "supercategories" => (in_array('supercategories', $arraySearch))? Supercategorie:: orderBy("id","desc")->get():null,
            "states"=>      (in_array('states', $arraySearch))?State:: orderBy("id","desc")->get(): null
       ]);




    }



}
