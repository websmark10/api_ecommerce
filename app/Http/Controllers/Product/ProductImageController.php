<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
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

         $file=$request->file("file");

        if ($request->hasFile("file") ) {
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $nombre = $file->getClientOriginalName();

            $path = Storage::putFile("productos",$file);
            $imagen=ProductImage::create([
                "product_id" => $request->product_id,
                "file_name" => $nombre,
                "imagen" => $path,
                "size" => $size,
                "ext" => $extension,
            ]);
        }

       return response()->json([
        "imagen"=>[
            "product_id" => $imagen->id,
            "file_name" => $imagen->file_name,
            "imagen" => env("APP_URL")."/storage/".$imagen->imagen,
            "size" => $imagen->size,
            "ext" => $imagen->ext,

        ]
       ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImage $productImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imagen=ProductImage::findOrFail($id);
        if($imagen->imagen){
            Storage::delete($imagen->imagen);
        }
        $imagen->delete();

         return response()->json(["message"=>200]);


    }
}
