<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Supercategorie;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Product\SupercategorieCollection;
use App\Http\Resources\Product\SupercategorieResource;
use App\Models\Product\State;
use App\Models\Store;

class SupercategorieController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth:api');

         parent::__construct();
     }

     public function test(){
        return "Funciona ruta productos/subcategorias test";
     }


    public function index(Request $request)
    {

       // $categorie_id=$request->get("cat_id")??null;
        $state = $request->get("state_id")??null;//''
        $search = $request->get("search")??null;

        /*
        return  response()->json([
            // "total"=>$supercategorie->total(),
            // "supercategorie"=>$supercategorie
            "folderCompanie"=>  $this->user->companie->folder_companie,
             "user"=>  $this->user



        ]);
*/

       // $supercategorie=Supercategorie::filterAdvance( $categorie_id,$state,$search)->orderBy("id","desc")->paginate(20);

       $store = Store::where(  "id",$request['store_id'])->with('companie')->first();
       $companie_id= $store->companie->id;

       $supercategories=Supercategorie::filterAdvance( $companie_id, $state,$search)->with(['creator','editor','destroyer'])->orderBy("name","asc")->paginate(20);

       $request->merge(['folder_companie'=> $this->user->companie->folder_companie]);




        return  response()->json([
            // "total"=>$supercategorie->total(),
            // "supercategorie"=>$supercategorie
            "totalData"=>count($supercategories),
            "data"=> SupercategorieCollection::make($supercategories),

        ]);

    }


    public function check_existence(Request $request)
    {

        $codes = $request->get("codes");
        $arraySearch=explode(',', $codes);

        $supercategories=Supercategorie::filterAdvanceNotExistence(  $arraySearch)->pluck('code')->toArray();

        $missed_codes=[];

        foreach ($arraySearch as $key => $value) {
            if (!in_array( $value, $supercategories ) &&  $value!=="") {
            array_push($missed_codes,$value );
           }
        }

        return  response()->json([
            "missed_codes"=>  $missed_codes
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

        $is_supercategorie = Supercategorie::where("name",$request->name)->first();
        if($is_supercategorie){
            return response()->json(["message" => 403, "codeMessage"=>"NameExists"]);
        }

        $supercategorie=Supercategorie::create($request->all());

        if($request->hasFile("imagen_file"))
        {
            $nameFile= $supercategorie->id.".jpg";
            $path = Storage::putFileAs("supercategories",$request->file("imagen_file"),$nameFile);
            $request->request->add(["imagen" =>$nameFile]);

            $supercategorie->imagen=$nameFile;
            $supercategorie->update();
       }

        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
            "supercategorie"=>$supercategorie
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supercategorie  $supercategorie
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {

        $supercategorie = SuperCategorie::findOrFail($id);

        return response()->json([
              "supercategorie" => SuperCategorieResource::make($supercategorie),  //No hago referencia a collection porque es un solo producto
              "states"=> State:: orderBy("id","desc")->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supercategorie  $supercategorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Supercategorie $supercategorie, $id)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supercategorie  $supercategorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         $supercategorie=Supercategorie::findOrFail($id);

        if($request->hasFile("imagen_file")){


                $nameFile=$id.".jpg";
                $path = Storage::putFileAs("supercategories",$request->file("imagen_file"),$nameFile);
                $request->request->add(["imagen" =>$nameFile]);

           }


        try {
            //$supercategorie->update($request->all());
            $supercategorie->update($request->all());

            return  response()->json([
                "codeState"=>200,
                "codeMessage"=>"Success",
                "supercategorie"=>$supercategorie,
                "Tiene Archivo"=>$request->hasFile("imagen_file"),
                "Nombre Archivo"=>$request->name,
                "Nombre imagen_file"=>$request->imagen_file,
                "Nombre imagen"=>$request->imagen
            ]);

        } catch (\Throwable $th) {
            return  response()->json([
                "message"=>400,
                "message_description"=>$th
            ]);
        }




    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supercategorie  $supercategorie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supercategorie=Supercategorie::findOrFail($id);
       // $supercategorie->delete();
            if($supercategorie->imagen){
                Storage::delete($supercategorie->imagen);
            }
        // $supercategorie->state_id=2;
        // $supercategorie->save();
        $supercategorie->delete();
        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
            "supercategorie" => new SupercategorieResource($supercategorie)
        ]);
    }
    public function change_state(Request $request,$id)
    {
        $supercategorie=Supercategorie::where("id",$id)->first();
        $supercategorie->state_id =$supercategorie->state->code==='Active'? 2:1;
        $supercategorie->save();
        return response()->json(["message"=>200,
        // "supercategorie" =>  SupercategorieCollection::make($supercategorie)
        "supercategorie" => new SupercategorieResource($supercategorie->fresh()),
        ]);

    }

}
