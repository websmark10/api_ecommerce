<?php

namespace App\Http\Controllers\People;

use Illuminate\Http\Request;
use App\Models\People\Store;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\Product\State;
use App\Http\Resources\People\StoreCollection;

class  StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
        // $this->middleware('auth:api');
     }


    public function index(Request $request)
    {



        $page=$request->page??1;
      //  $pageSize=$request->page_size??20;
        $limitToShow=  $request->limit;
        $limitToShow=1000;
        $search = $request->get("search");
        $state_id=$request->state_id;
        $pageSize=$request->page_size??null;

        $companie_id=$request->companie_id;

        $user=auth()->user();

        // return response()->json([
        //     "user"=>$user,

        //     ]);


       $stores=Store::where("companie_id",$companie_id)->filterAdvance( $state_id,$search)->with(['creator','editor','destroyer'])->orderBy("id","desc")->paginate($pageSize);






            return response()->json([
                "message"=>"200",
                "totalData" => $stores->total(),
                     "data" =>  StoreCollection::make($stores)


                ]);

    }

    public function index_short(Request $request)
    {



        $companie_id=$request->companie_id;

        $user=auth()->user();

       $stores=Store::where("companie_id",$companie_id)->orderBy("id","desc")->get();

            return response()->json([
                "message"=>"200",
                "totalData" => count( $stores) ,
                     "data" =>  StoreCollection::make($stores)
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

    //    $request->merge([
    //         'description' =>'',
    //     ]);
      //  return  $request->description;
        $is_brand = Brand::where("name",$request->name)->first();
        if($is_brand){
            return response()->json(["message" => 403, "codeMessage"=>"NameExists"]);
        }

        $brand=Brand::create($request->all());

        if($request->hasFile("imagen_file"))
        {
            $nameFile= $brand->id.".jpg";
            $path = Storage::putFileAs("stores",$request->file("imagen_file"),$nameFile);
            $request->request->add(["imagen" =>$nameFile]);

            $brand->imagen=$nameFile;
            $brand->update();
       }

        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
            "brand"=>$brand
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $brand = Brand::findOrFail($id);

        return response()->json([
              "brand" => BrandResource::make($brand),  //No hago referencia a collection porque es un solo producto
              "states"=> State:: orderBy("id","desc")->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand, $id)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         $brand=Brand::findOrFail($id);

        if($request->hasFile("imagen_file")){


                $nameFile=$id.".jpg";
                $path = Storage::putFileAs("stores",$request->file("imagen_file"),$nameFile);
                $request->request->add(["imagen" =>$nameFile]);

           }


        try {
            //$brand->update($request->all());
            $brand->update($request->all());

            return  response()->json([
                "codeState"=>200,
                "codeMessage"=>"Success",
                "brand"=>$brand,
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand=Brand::findOrFail($id);
       // $brand->delete();
            if($brand->imagen){
                Storage::delete($brand->imagen);
            }
        // $brand->state_id=2;
        // $brand->save();
        $brand->delete();
        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
            "brand" => new BrandResource($brand)
        ]);
    }


    public function change_state(Request $request,$id)
    {
       //$state_id= $request->state_id;

        $brand=Brand::where("id",$id)->first();
        $brand->state_id =$brand->state->code==='Active'? 2:1;
        $brand->save();

        return response()->json(["message"=>200,
       // "brand" =>  BrandCollection::make($brand)
       "brand" => new BrandResource($brand->fresh()),

        ]);

    }

}
