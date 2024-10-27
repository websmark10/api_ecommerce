<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Subcategorie;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Product\SubcategorieCollection;
use App\Http\Resources\Product\SubcategorieResource;

class SubcategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('auth:api');
         parent::__construct();
     }

     public function test(){
        return "Funciona ruta productos/subcategories test";
     }


    public function index(Request $request)
    {

        $subcategorie_id=$request->get("cat_id");
        $state = $request->get("state_id");//''
        $search = $request->get("search");
        $pageSize=$request->page_size??null;




       // $subcategories=Subcategorie::filterAdvance( $subcategorie_id,$state,$search)->orderBy("id","desc")->paginate(20);

        $request->merge(['folder_companie'=> $this->user->companie->folder_companie]);



        if ($pageSize)
        {
            $subcategories=Subcategorie::filterAdvance( $subcategorie_id,$state,$search)->with(['creator','editor','destroyer'])->orderBy("name","asc")->paginate(20);

            return  response()->json([
                "totalData"=>count($subcategories),
                "data"=> SubcategorieCollection::make($subcategories)
            ]);
        }
         else
         {
            $subcategories=Subcategorie::filterAdvance( $subcategorie_id,$state,$search)->with(['creator','editor','destroyer'])->orderBy("name","asc")->get();

            return  response()->json([
                "totalData"=>count($subcategories),
                "data"=>  $subcategories
            ]);
         }


    }


    public function check_existence(Request $request)
    {

        $codes = $request->get("codes");
        $arraySearch=explode(',', $codes);

        $subcategories=Subcategorie::filterAdvanceNotExistence(  $arraySearch)->pluck('code')->toArray();

        $missed_codes=[];

        foreach ($arraySearch as $key => $value) {
            if (!in_array( $value, $subcategories ) &&  $value!=="") {
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

        $is_subcategorie = Subcategorie::where("name",$request->name)->first();
        if($is_subcategorie){
            return response()->json(["message" => 403, "codeMessage"=>"NameExists"]);
        }

        $subcategorie=Subcategorie::create($request->all());

        if($request->hasFile("imagen_file"))
        {
            $nameFile= $subcategorie->id.".jpg";
            $path = Storage::putFileAs("subcategories",$request->file("imagen_file"),$nameFile);
            $request->request->add(["imagen" =>$nameFile]);

            $subcategorie->imagen=$nameFile;
            $subcategorie->update();
       }

        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
            "categorie"=>$subcategorie
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategorie  $subcategorie
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {

        $subcategorie = Subcategorie::findOrFail($id);

        return response()->json([
              "subcategorie" => SubcategorieResource::make($subcategorie),  //No hago referencia a collection porque es un solo producto
              //"states"=> State:: orderBy("id","desc")->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategorie  $subcategorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategorie $subcategorie, $id)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategorie  $subcategorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         $subcategorie=Subcategorie::findOrFail($id);

        if($request->hasFile("imagen_file")){


                $nameFile=$id.".jpg";
                $path = Storage::putFileAs("subcategories",$request->file("imagen_file"),$nameFile);
                $request->request->add(["imagen" =>$nameFile]);

           }


         try {
            //$categorie->update($request->all());
            $subcategorie->update($request->all());

            return  response()->json([
                "codeState"=>200,
                "codeMessage"=>"Success",
                "subcategorie"=>$subcategorie,
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
     * @param  \App\Models\Subcategorie  $subcategorie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategorie=Subcategorie::findOrFail($id);
       // $subcategorie->delete();
            if($subcategorie->imagen){
                Storage::delete($subcategorie->imagen);
            }
        $subcategorie->state=2;
        $subcategorie->save();
        $subcategorie->delete();
        return  response()->json([
            "message"=>200
        ]);
    }

    public function change_state(Request $request,$id)
    {
       //$state_id= $request->state_id;

        $subcategorie=Subcategorie::where("id",$id)->first();
        $subcategorie->state_id =$subcategorie->state->code==='Active'? 2:1;
        $subcategorie->save();

        return response()->json(["message"=>200,
       // "subcategorie" =>  SupercategorieCollection::make($subcategorie)
       "subcategorie" => new SubcategorieResource($subcategorie->fresh()),

        ]);

    }
}
