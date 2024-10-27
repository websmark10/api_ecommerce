<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product\ProductSize;
use App\Models\Product\ProductColorSize;

class ProductColorSizeController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    //    return response()->json([ "product_size_id"=>$request->product_size_id]);

        if(!$request->product_size_id){

            $product_size=ProductSize::where("name",$request->new_size)->first();
            if($product_size){
                return response()->json(["message"=>403 , "codeMessage"=> "ConfigExists" ]);
            }
            //Crear un nuevo tamaño
            $product_size=  ProductSize::create([
                "product_id"=>$request->product_id,
                "name"=>$request->new_size,

            ]);

         }else{
                      //Acabo de seleccionar una dimension
            $product_size=ProductSize::findOrFail($request->product_size_id);


         }



        $product_color_size=ProductColorSize::where("product_color_id",$request->product_color_id)->where("product_size_id",$product_size->id)->first();


        if($product_color_size){
            return response()->json(["message"=>403 , "codeMessage"=> "ConfigExists" ]);
        }

         $product_color_size  = ProductColorSize::create([
                "product_color_id"=> $request->product_color_id,
                "product_size_id"=>   $product_size->id,
                "stock"=> $request->stock,
            ]);


     return response()->json(["message" => 200 , "product_color_size" => [
                "id" => $product_size->id,
                "name" => $product_size->name,
                "total" => $product_size->product_color_sizes->sum("stock"),
                "variaciones" => $product_size->product_color_sizes->map(function($var){
                    return [
                        "id" => $var->id,
                        "product_color_id" => $var->product_color_id,
                        "product_color" => $var->product_color,
                        "stock" => $var->stock,
                    ];
                }),
            ]]);

            // return response()->json(["message" => 200 , "product_color_size" => [
            //     "id" => $product_size->id,
            //     "name" => $product_size->name,
            //     "total" => $product_size->product_color_sizes->sum("stock"),
            //     "variaciones" => $product_size->product_color_sizes->map(function($var){
            //         return [
            //             "id" => $var->id,
            //             "product_color_id" => $var->product_color_id,
            //             "product_color" => $var->product_color,
            //             "stock" => $var->stock,
            //         ];
            //     }),
            // ]]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product\ProductColorSize  $productColorSize
     * @return \Illuminate\Http\Response
     */
    public function show(ProductColorSize $productColorSize)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product\ProductColorSize  $productColorSize
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductColorSize $productColorSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product\ProductColorSize  $productColorSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $product_color_size=ProductColorSize::where("id","<>",$id)->where("product_color_id",$request->product_color_id)->where("product_size_id",$request->product_size_id)->first();
        if($product_color_size){
            return response()->json(["message"=>403 , "codeMessage"=> "ConfigExists" ]);
        }


         $product_color_size=ProductColorSize ::findOrFail($id);
         $product_color_size->update($request->all());

         return response()->json(["message"=>200,
         "total"=>  $product_color_size->product_size->product_color_sizes->sum("stock"),
         "product_color_size"=>[
            "id"=>$product_color_size->id,
            "product_color_id"=> $product_color_size->product_color_id,
            "product_color"=>$product_color_size->product_color,
            "stock"=>$product_color_size->stock
        ]

         ]);

    }

    public function update_size(Request $request, $id)
    {

        $product_size=ProductSize::where("id","<>",$id)->where("name",$request->name)->first();
        if($product_size){
            return response()->json(["message"=>403 ,  "codeMessage"=> "ConfigExists" ]);
        }


        $product_size= ProductSize::findOrFail($id);
        $product_size->update($request->all());

        return response()->json(["message"=>200,
        "product_size" =>
            [
                "id"=>  $product_size->id,
                "name"=>  $product_size->name,
                "total"=>  $product_size->product_color_sizes->sum("stock"),
                "variaciones"=>  $product_size->product_color_sizes->map(function($variacion){
                    return [
                        "id"=>$variacion->id,
                        "product_color_id"=> $variacion->product_color_id,
                        "product_color"=>$variacion->product_color,
                        "stock"=>$variacion->stock
                    ];
                }), //Sin el MAP solo se ven los ids
            ]
        ]);


    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\ProductColorSize  $productColorSize
     * @return \Illuminate\Http\Response
     */


    public function destroy_size($id)
    {
        $product_size=ProductSize::findOrFail($id);
        $product_size->delete();

        return response()->json(["message"=>200]);

    }

   public function destroy($id)
    {
        $product_color_size= ProductColorSize::findOrFail($id);
        $product_color_size->delete();

        return response()->json(["message"=>200, "product_color_size_id"=> $id,  "total"=>  $product_color_size->product_size->product_color_sizes->sum("stock")]);

    }

}
