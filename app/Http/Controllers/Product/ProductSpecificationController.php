<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductSpecification;
use App\Models\Product\Product;

class ProductSpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $product_id = $request->product_id;


        $specifications = ProductSpecification::where("product_id",$product_id)->orderBy("id","desc")->get();


        return response()->json([
            "specifications" =>  $specifications->map(function($specification) {
                return [
                    "id" => $specification->id,
                    "product_id" => $specification->product_id,
                   "attribute" =>
                     [
                        "id" =>$specification->attribute->id,
                        "name" =>$specification->attribute->name,
                       "ref" =>$specification->attribute->ref,
                     ],
                    "cat_attribute" =>
                     [
                        "name" =>$specification->attribute->product_variant_attr_cat->name,
                       "type" => $specification->attribute->product_variant_attr_cat->cat_attribute_type->code,
                     ],
                    //"propertie_id" => $specification->propertie_id,
                    // "propertie" => $specification->propertie ? [
                    //     "name" => $specification->propertie->name,
                    //     "code" => $specification->propertie->code,
                    // ] : NULL,
                    "value" => $specification->value,
                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $is_valid_variation = null;



        if($request->propertie_id){
            $is_valid_variation = ProductSpecification::where("product_id",$request->product_id)
                                                    ->where("attribute_id",$request->attribute_id)
                                                    ->where("cat_attribute_id",$request->cat_attribute_id)
                                                    ->first();
        }else{
            $is_valid_variation = ProductSpecification::where("product_id",$request->product_id)
                                                        ->where("cat_attribute_id",$request->cat_attribute_id)
                                                        ->where("value",$request->value)
                                                        ->first();
        }
        if($is_valid_variation){
            return response()->json(["message" => 403,"message_text" => "LA ESPECIFICACIÓN YA EXISTE, INTENTE OTRA COMBINACIÓN"]);
        }


      //  $product_specification = ProductSpecification::create($request->all());
      $product_specification = ProductSpecification::create
       ([
        "product_id" =>  $request->product_id,
        "attribute_id" => $request->attribute_id,
        "cat_attribute_id" => $request->cat_attribute_id,
        "value"=>  $request->value,
        "state_id" =>1,
        "companie_id" =>$this->user->companie->id,
       ]);


        return response()->json([
            "message" => 200,
            "specification" => [
                "id" => $product_specification->id,
                "product_id" => $product_specification->product_id,
                "cat_attribute" =>
                 [
                    "id"=> $product_specification->cat_attribute->id,
                    "code" => $product_specification->cat_attribute->code,
                    "type"=> [
                        "id"=> $product_specification->cat_attribute->cat_attribute_type->id,
                        "code"=> $product_specification->cat_attribute->cat_attribute_type->code

                    ],
                    "attribute" => $product_specification->attribute ? [
                    "name" => $product_specification->attribute->name,
                     ] : NULL

                ],
                "value" => $product_specification->value,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $is_valid_variation = null;
        if($request->propertie_id){
            $is_valid_variation = ProductSpecification::where("product_id",$request->product_id)
                                                    ->where("id","<>",$id)
                                                    ->where("attribute_id",$request->attribute_id)
                                                    ->where("propertie_id",$request->propertie_id)
                                                    ->first();
        }else{
            $is_valid_variation = ProductSpecification::where("product_id",$request->product_id)
                                                    ->where("id","<>",$id)
                                                        ->where("attribute_id",$request->attribute_id)
                                                        ->where("value_add",$request->value_add)
                                                        ->first();
        }
        if($is_valid_variation){
            return response()->json(["message" => 403,"message_text" => "LA ESPECIFICACIÓN YA EXISTE, INTENTE OTRA COMBINACIÓN"]);
        }

        $product_specification = ProductSpecification::findOrFail($id);
        $product_specification->update($request->all());
        return response()->json([
            "message" => 200,
            "specification" => [
                "id" => $product_specification->id,
                "product_id" => $product_specification->product_id,
                "attribute_id" => $product_specification->attribute_id,
                "attribute" => $product_specification->attribute ? [
                    "name" => $product_specification->attribute->name,
                    "type_attribute" => $product_specification->attribute->type_attribute,
                ] : NULL,
                "propertie_id" => $product_specification->propertie_id,
                "propertie" => $product_specification->propertie ? [
                    "name" => $product_specification->propertie->name,
                    "code" => $product_specification->propertie->code,
                ] : NULL,
                "value_add" => $product_specification->value_add,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product_variation = ProductSpecification::findOrFail($id);
        $product_variation->delete();
        // UNA VALIDACIÓN PARA QUE NO SE PUEDA ELIMINAR EN CASO EL PRODUCTO O LA VARACION ESTE EN EL CARRITO DE COMPRA O EN EL DETALLADO DE ALGUNA COMPRA
        return response()->json([
            "message" => 200,
        ]);
    }
}
