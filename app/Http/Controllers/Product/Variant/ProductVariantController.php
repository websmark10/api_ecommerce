<?php

namespace App\Http\Controllers\Product\Variant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Variant\ProductVariant;
use Illuminate\Support\Facades\Storage;
use App\Models\Product\Variant\ProductVariantImage;
use App\Http\Resources\Product\VariantCollection;
use App\Http\Resources\Product\VariantResource;
use App\Models\Inventory\Inventory;
use Illuminate\Support\Facades\DB;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    /*    $variant=ProductVariant::findOrFail(5);

        return response()->json([
            "data" =>  VariantResource::make($variant),
        ]);

*/

// return response()->json([
//     "datauser" => $this->user->companie->id,
// ]);





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
          // Add new Variant of Product with dim && att



        $is_variant = ProductVariant::where("sku",$request->sku)->first();

        if($is_variant){
            if($request->variant_id)
            return response()->json(["message" => 403, "codeMessage"=>"SkuExists"]);
        }

        $companie_id= $this->user->companie->id;
        $imagen= json_decode($request->imagen);


        if($request->cover){
               ProductVariant::where("product_id",$request->product_id)->where("cover",1)->update(['cover' => 0]);

        }

        $new_product_variant=ProductVariant::create([

             "product_variant_state_id"=>$request->product_variant_state_id,
             "image"=> $imagen->name,
             "minimum_quantity"=>$request->minimum_quantity,
             "online"=>$request->online,
             "cover"=>$request->cover,
             "product_variant_dimension_id"=>$request->product_variant_dimension_id,
             "product_variant_attribute_id"=>$request->product_variant_attribute_id,
             "product_id"=>$request->product_id,
             "sku"=>$request->sku,

        ]);

        $new_inventory=Inventory::create([
             //"batch_id"=> null   ,
             "product_id"=>$request->product_id   ,
             "inventory_source_id"=>3  , //Manual
             "product_variant_id"=>  $new_product_variant->id  ,
             "store_id"=>$request->store_id   ,
             "provider_id"=>1  , //MYSELF
             "stock"=>$request->stock   ,
             "manufactured_date"=>$request->manufactured_date   ,
             "expiry_date"=>$request->expiry_date   ,
             "price"=>$request->price   ,
             "cost"=>$request->cost   ,
             "sold"=>0   ,
             "available"=>$request->stock  ,
             "companie_id"=> $this->user->companie->id
       ]);




        $folder_companie=  $this->user->companie->folder_companie;

         $directory_imagen =($request->inventory_type_id==1) ?"companies/". $folder_companie ."/products/":
                "companies/". $folder_companie ."/products/".$request->product_id."/variants/".$new_product_variant->id."/";

                //         companies/0001_MIDESPENSA/products/5/variants/16/




        if($request->hasFile("imagen_file")){


            $nameFile=($request->inventory_type_id==1)? $request->sku.".jpg":$request->file("imagen_file")->getClientOriginalName();

            $path =($request->inventory_type_id==1)? Storage::putFileAs($directory_imagen ,$request->file("imagen_file"),$nameFile):
                                                        Storage::putFileAs($directory_imagen ,$request->file("imagen_file"),$nameFile);


        }



        $directory_images =($request->inventory_type_id==1)? "companies/". $folder_companie ."/products/".$request->product_id."/images/":
        "companies/". $folder_companie ."/products/".$request->product_id."/variants/". $new_product_variant->id."/images/";


if($request->hasFile("images_files")){

        foreach ($request->file("images_files")as $key => $file)
        {
        $newProductImage =  ProductVariantImage::create([
            "product_variant_id"=>  $new_product_variant->id,
            "product_id" => $request->product_id,
            "companie_id"=>  $companie_id,
                "name" =>$file->getClientOriginalName(),
            "size" =>  $file->getSize(),
            "type" => $file->getMimeType(),
        ]);


        Storage::putFileAs( $directory_images,$file, $file->getClientOriginalName());



        }

}



        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
            "variant"=>   VariantResource::make($new_product_variant)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $variant=ProductVariant::findOrFail($id);
         $excTransaction=null;


        DB::beginTransaction();
        try {

            $variant->inventory()->delete();
            $variant->product_variant_images()->delete();
            $variant->discount_variants()->delete();
            $variant->delete();
        DB::commit();
        } catch (\Exception $e) {
        DB::rollback();
       $excTransaction= $e->getMessage();
        //return $e->getMessage();
        }




        $folder_companie=  $this->user->companie->folder_companie;

        $directory_variant ="companies/". $folder_companie ."/products/".$variant->product->id."/variants/".$variant->id;

        $storageFiles = Storage::allFiles($directory_variant);

        foreach ( $storageFiles as $file)
        {
            if($file != '.'&& $file != '')
            {
              unlink(storage_path('app\\public\\'.  str_replace('/','\\', $file)));
            }
        }

        if( Storage::exists($directory_variant."/images"))
        rmdir(storage_path('app\\public\\'. str_replace('/','\\', $directory_variant)."\\images"));

        if( Storage::exists($directory_variant))
        rmdir(storage_path('app\\public\\'. str_replace('/','\\', $directory_variant)));

         return  response()->json([
             "codeState"=>200,
             "codeMessage"=>"Success",
             "exception transaction "=> $excTransaction,
           // "variant"=> $variant,

         ]);


    }






}
