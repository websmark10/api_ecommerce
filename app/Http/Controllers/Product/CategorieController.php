<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Categorie;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Product\CategorieCollection;
use App\Http\Resources\Product\CategorieResource;
use App\Models\Product\State;
use App\Models\Product\Supercategorie;

class CategorieController extends Controller
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



        $super_categorie_id=$request->get("supcat_id");
        $state = $request->get("state_id");//''
        $search = $request->get("search");
        $pageSize=$request->page_size??null;

 

         $request->merge(['folder_companie'=> $this->user->companie->folder_companie]);

         if ($pageSize)
         {



         $categories=Categorie::filterAdvance( $super_categorie_id,$state,$search)->with(['creator','editor','destroyer'])->orderBy("id","desc")->paginate($pageSize);
         return  response()->json([
            "totalData"=>$categories->count(),
          "data"=> CategorieCollection::make($categories)

        ]);
         }
          else
          {

         $categories=Categorie::filterAdvance( $super_categorie_id,$state,$search)->with(['creator','editor','destroyer'])->orderBy("id","desc")->get();





         return  response()->json([
             "totalData"=>$categories->count(),
            // "data"=> $categories
          "data"=> CategorieCollection::make($categories)
        ]);
          }




    }


    public function check_existence(Request $request)
    {

        $codes = $request->get("codes");
        $arraySearch=explode(',', $codes);

        $categories=Categorie::filterAdvanceNotExistence(  $arraySearch)->pluck('code')->toArray();

        $missed_codes=[];

        foreach ($arraySearch as $key => $value) {
            if (!in_array( $value, $categories ) &&  $value!=="") {
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

        $is_categorie = Categorie::where("name",$request->name)->first();
        if($is_categorie){
            return response()->json(["message" => 403, "codeMessage"=>"NameExists"]);
        }

        $categorie=Categorie::create($request->all());

        if($request->hasFile("imagen_file"))
        {
            $nameFile= $categorie->id.".jpg";
            $path = Storage::putFileAs("categories",$request->file("imagen_file"),$nameFile);
            $request->request->add(["imagen" =>$nameFile]);

            $categorie->imagen=$nameFile;
            $categorie->update();
       }

        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
            "categorie"=>$categorie
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {

        $categorie = Categorie::findOrFail($id);

        return response()->json([
              "categorie" => CategorieResource::make($categorie),  //No hago referencia a collection porque es un solo producto
            //   "states"=> State:: orderBy("id","desc")->get(),
            //   "supercategories"=> Supercategorie:: orderBy("id","desc")->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie, $id)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         $categorie=Categorie::findOrFail($id);

        if($request->hasFile("imagen_file")){


                $nameFile=$id.".jpg";
                $path = Storage::putFileAs("categories",$request->file("imagen_file"),$nameFile);
                $request->request->add(["imagen" =>$nameFile]);

           }


        try {
            //$categorie->update($request->all());
            $categorie->update($request->all());

            return  response()->json([
                "codeState"=>200,
                "codeMessage"=>"Success",
                "categorie"=>$categorie,
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
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorie=Categorie::findOrFail($id);
       // $categorie->delete();
            if($categorie->imagen){
                Storage::delete($categorie->imagen);
            }
        // $categorie->state_id=2;
        // $categorie->save();
        $categorie->delete();
        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
            "categorie" => new CategorieResource($categorie)
        ]);
    }
    public function change_state(Request $request,$id)
    {
        $categorie=Categorie::where("id",$id)->first();
        $categorie->state_id =$categorie->state->code==='Active'? 2:1;
        $categorie->save();
        return response()->json(["message"=>200,
        // "categorie" =>  CategorieCollection::make($categorie)
        "categorie" => new CategorieResource($categorie->fresh()),
        ]);

    }

}
