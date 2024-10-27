<?php

namespace App\Http\Controllers\Product;

// use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\DB;

use App\Models\Product\Product;
use Illuminate\Http\Request;
use App\Models\Product\ProductImage;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductCCollection;
use App\Models\Product\Categorie;
use App\Models\Product\ProductColor;
use App\Models\Product\ProductSize;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Product\ProductCResource;
use App\Models\Product\Supercategorie;
use App\Models\Product\Brand;
use App\Models\Product\Unit;
use App\Models\Product\Tax;
use App\Models\Discount\DiscountType;
use App\Models\Product\ProductState;
use App\Models\Inventory\InventoryType;
use App\Models\Product\State;
use App\Models\Product\Subcategorie;
use App\Http\Resources\Product\ProductListCollection;

use App\Models\Product\Variant\ProductVariantAttribute;
use App\Models\Product\Variant\ProductVariantDimension;
use App\Models\Product\Variant\ProductVariant;

use App\Models\People\Store;
use App\Http\Resources\Product\ProductEditCollection;
use App\Models\Product\TaxType;
use App\Models\Product\Variant\ProductVariantState;
use App\Http\Resources\Product\ProductDetailsCollection;
use App\Models\Product\Variant\ProductVariantImage;
use App\Models\Discount\Discount;
use Carbon\Carbon;

use App\Models\Inventory\Inventory;
use App\Models\Product\Variant\ProductVariantAttrCat;
use App\Models\Product\ProductSpecification;
use App\Http\Resources\Product\ProductSpecificationCollection;
//use App\Http\Resources\Product\ProductCResource;

class ProductController extends Controller
{
     public function __construct()
     {
         $this->middleware('auth:api');
         parent::__construct();
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $page=$request->page??1;
       // return $request;
       $pageSize=$request->page_size??3;
       $limitToShow=  $request->limit;
       $limitToShow=100;
        $search = $request->search;

        $supercategorie_id = $request->supercat_id;
        $categorie_id = $request->cat_id;
        $subcategorie_id = $request->subcat_id;
        $brand_id=$request->brand_id;
        $unit_id=$request->unit_id;
        $state_id=$request->state_id;

       // return $state_id;
        // $products = Product::filterProduct($search,$categorie_id)->orderBy("id","desc")->paginate( $request->limit);
        //$products = Product::filterProduct($supercategorie_id , $categorie_id , $subcategorie_id, $brand_id, $unit_id, $search )->orderBy("id","desc")->take(   $limitToShow)->get();


        $store = Store::where(  "id",$request['store_id'])->with('companie')->first();
        $companie_id= $store->companie->id;

         $products = Product::filterProduct($companie_id,$supercategorie_id , $categorie_id , $subcategorie_id, $brand_id, $unit_id,  $state_id,$search )->with(['creator','editor','destroyer'])->orderBy("id","desc")->paginate($pageSize);

      //   $product->folder_companie= $this->user->companie->folder_companie;

         $request->merge(['folder_companie'=> $this->user->companie->folder_companie]);

        //  return $products;

         //$total=count($products);

         //$products = $products ->take(   $limitToShow);
        //return ProductCCollection::make($products);



        return response()->json([
            //"message" => 200,
            // "total" => $products->total(),
            // "products" => ProductCCollection::make($products),
           "totalData" => $products->total(),
            "data" => ProductCCollection::make($products),
          // "data" => ProductListCollection::make($products),
            //"data" =>$products->take( 20)->get(),
        ]);


        // return response()->json([
        //     "product" => ProductCResource::make($product),  //No hago referencia a collection porque es un solo producto
        // ]);


    }


    public function list(Request $request)
    {



        $page=$request->page??1;
        $store_id =$request->store_id;
       // return $request;
       $pageSize=$request->page_size??3;
       $limitToShow=  $request->limit;
       $limitToShow=100;
        $search = $request->search;

        $supercategorie_id = $request->supercat_id;
        $categorie_id = $request->cat_id;
        $subcategorie_id = $request->subcat_id;
        $brand_id=$request->brand_id;
        $unit_id=$request->unit_id;
        $state_id=$request->state_id;

       // return $state_id;
        // $products = Product::filterProduct($search,$categorie_id)->orderBy("id","desc")->paginate( $request->limit);
        //$products = Product::filterProduct($supercategorie_id , $categorie_id , $subcategorie_id, $brand_id, $unit_id, $search )->orderBy("id","desc")->take(   $limitToShow)->get();



        $store = Store::where(  "id",$request['store_id'])->with('companie')->first();
        $companie_id= $store->companie->id;

         $products = Product::filterProduct($companie_id,$supercategorie_id , $categorie_id , $subcategorie_id, $brand_id, $unit_id,  $state_id,$search )->with(['creator','editor','destroyer'])->orderBy("id","desc")->paginate($pageSize);


         $request->merge(['folder_companie'=> $this->user->companie->folder_companie]);


        return response()->json([
           "totalData" => $products->total(),
           "data" => ProductListCollection::make($products),
           // "data" => ProductCCollection::make($products),
           // "data2" => ProductEditCollection::make( [$products])[0],
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

    public function get_info()
    {

       $supercategories = Supercategorie::orderBy("name","asc")->get();

     //  $categories = Categorie::orderBy("id","desc")->get();

      // $product_colors = ProductColor::orderBy("id","desc")->get();

       //$product_sizes = ProductSize::orderBy("id","desc")->get();
       $variant_dimensions= ProductVariantDimension::orderBy("id","desc")->get();

       $variant_attributes= ProductVariantAttribute::orderBy("id","desc")->get();

       $product_variant_states = ProductVariantState::orderBy("id","desc")->get();

       $brands = Brand::orderBy("name","asc")->get();

       $units = Unit::orderBy("name","desc")->get();

       $taxes = Tax::orderBy("id","asc")->get();

       $states = State::orderBy("id","asc")->get();

       $discount_types = DiscountType::orderBy("id","asc")->get();

       $inventory_types = InventoryType::orderBy("id","asc")->get();


       return response()->json(["supercategories" => $supercategories,
       "states" => $states,
       "brands" => $brands,
       "units" => $units,
       "taxes" => $taxes,
    //    "product_colors" => $product_colors ,
    //    "product_sizes" => $product_sizes,
       "variant_dimensions"=>$variant_dimensions,
       "variant_attributes"=>$variant_attributes,
       "product_states" => $product_variant_states,
       "discount_types"=>$discount_types,
       "inventory_types" => $inventory_types,
       ]
       );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_product = Product::where("title",$request->title)->orWhere('sku',$request->sku)->first();
        if($is_product){
            return response()->json(["message" => 403, "codeMessage"=>"SkuExists"]);
        }

       // $request->request->add(["tags_e" => Str::implode(',',$request->tags_e)]);
        $request->request->add(["slug" => Str::slug($request->title)]);
        $request->request->add(["tags" => ""]);
        //$request->request->add(["price" => "10101000"]);
        //$request->request->add(["resumen" => "todook"]);
        //$request->request->add(["prodstate_id" => 1]);
        $product = Product::create($request->all());


        if($request->hasFile("imagen_file")){
            $nameFile= $product->sku.".jpg";
            $path = Storage::putFileAs("products",$request->file("imagen_file"),$nameFile);
            $request->request->add(["imagen" => $nameFile]);
            $product->imagen=$nameFile;
            $product->update();
        }



        if($request->hasFile("images_files")){
        foreach ($request->file("images_files") as $key => $file) {
           // $path = Storage::putFile("products/".$product->sku,$file);
          // Storage::putFileAs("products/".$product->sku,$file,$file->getClientOriginalName());

          $productImage=  ProductImage::create([
                "product_id" => $product->id,
                "name" =>$file->getClientOriginalName(),
                "size" =>  $file->getSize(),
                "type" => $file->getMimeType(),
            ]);
            Storage::putFileAs("products/".$product->sku,$file,$productImage->name);
        }
    }

        return response()->json(["message" => 200,"product"=>$product ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $product = Product::findOrFail($id);




        $subcat_id= $product->subcategorie->id;

        $cat_id= $product->subcategorie->categorie->id;

        $supcat_id= $product->subcategorie->categorie->supercategorie->id;
        $companie_id=$product->companie_id;

        $product->folder_companie= $this->user->companie->folder_companie;





        $product_variant_states = ProductVariantState::where("companie_id",$companie_id)->orderBy("name","asc")->get();
        $supercategoriesProduct = Supercategorie::where("companie_id",$companie_id)->orderBy("name","asc")->get();
        $categoriesProduct = Categorie::where("supercategorie_id",$supcat_id )->orderBy("name","asc")->get();
        $subcategoriesProduct = Subcategorie::where("categorie_id",  $cat_id )->orderBy("name","asc")->get();
        $categoriesAttribute = ProductVariantAttrCat::where("companie_id",$companie_id)->orderBy("name","asc")->get();

        $variant_dimensions= ProductVariantDimension::orderBy("id","desc")->get();
        $variant_attributes= ProductVariantAttribute::orderBy("id","desc")->get();

        $brands = Brand::where("companie_id",$companie_id)->orderBy("name","asc")->get();
        $units = Unit::where("companie_id",$companie_id)->orderBy("name","desc")->get();
        $taxes = Tax::where("companie_id",$companie_id)->orderBy("id","asc")->get();
        $states = State::orderBy("id","asc")->get();
         $tax_types = TaxType::where("companie_id",$companie_id)->orderBy("id","asc")->get();
        $discount_types = DiscountType::orderBy("id","asc")->get();
        $inventory_types = InventoryType::orderBy("id","asc")->get();        //return  $product->folder_companie;
        $discounts_apply_product= Discount::where("companie_id",$companie_id)->whereRaw('(now() between start_date and end_date)')->where("discount_apply_id","1")->orderBy("id","desc")->get();

        $specifications = ProductSpecification::where("product_id",$product->id)->orderBy("id","desc")->get();

        return response()->json([

            "specifications"=> ProductSpecificationCollection::make($specifications),
            "data" => ProductDetailsCollection::make( [$product])[0],
             "categories_attribute"=> $categoriesAttribute->map(function($cat_attr){
                return
                        [
                           "id"=> $cat_attr->id,
                           "name"=> $cat_attr->name,
                           "attr_cat_type_id"=> $cat_attr->attr_cat_type_id,
                           "attributes"=>  $cat_attr->attributes->map(function($attr){
                            return [
                                "id"=> $attr->id,
                                "name"=> $attr->name,
                                "ref"=>$attr->ref
                             ];
                           })
                        ];
            }),
             "supercategories"=> $supercategoriesProduct,
             "categories"=> $categoriesProduct ,
             "subcategories"=> $subcategoriesProduct,
             "states" => $states,
             "brands" => $brands,
             "units" => $units,
             "taxes" => $taxes,
             "product_variant_states"=>$product_variant_states,
          //    "product_colors" => $product_colors ,
          //    "product_sizes" => $product_sizes,
             "variant_dimensions"=>$variant_dimensions,
             "variant_attributes"=>$variant_attributes,
             "discount_types"=>$discount_types,
              "tax_types"=>$tax_types,
             "inventory_types" => $inventory_types,
             "discounts_apply_product"=> $discounts_apply_product->map(function($discount){
                return
                        [
                           "id"=> $discount->id,
                           "code"=> $discount->code,
                           "discount_type"=> [
                                        "id"=> $discount->discount_type->id,
                                        "code"=> $discount->discount_type->code,
                           ],
                           "discount"=>$discount->discount,
                           "start_date"=> $discount->start_date,
                           "end_date"=> $discount->end_date,
                        ];
            }),


            // "data" => [$product][0],
             // "product" => ProductCResource::make($product),  //No hago referencia a collection porque es un solo producto
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


        // return response()->json
        // ([
        // "message" => 200 ,
        // "product_variant_state_id"=>$request->product_variant_state_id,

        // ]);
      //  return response()->json(["message" => $request->all()]);


     // return response()->json(["message" => $request->sku]);


        $is_product = ProductVariant::where("product_id","<>",$id)->where("sku",$request->sku)->first();

        // if($is_product){
        //     return response()->json(["message" => 403, "codeMessage"=>"SkuExists"]);
        // }

        $product = Product::findOrFail($id);


      // return response()->json(["companie_id" => $product->companie_id]);



         $product->subcategorie_id=$request->subcategorie_id;
         $product->brand_id=$request->brand_id;
         $product->unit_id=$request->unit_id;
         $product->tax_id=$request->tax_id;
         $product->title=$request->title;
         $product->slug=Str::slug($request->title);
         $product->tags=$request->tags;
         $product->description=$request->description;
         $product->summary=$request->summary;
         $product->companie_id=$product->companie_id;
         $product->inventory_type_id=$request->inventory_type_id;

        //  $product->variants()->where('cover',$request->variant_id);
        //  Product::findOrFail($id);

        $variant_id=$request->variant_id;


        if( $variant_id== 'null') {
            $product->push();
            return response()->json
            ([
            "message" => 200 ,
            "Variantes"  =>"Multiple no seleccionada"
            ]);

        }


        //En Caso de que se cambie de imagen de portada
        if(  $request->cover)
            ProductVariant::where("product_id",$product->id)->where("cover",1)->update(['cover' => 0]);




         $product-> variant($variant_id) ->online=$request->online;
         $product-> variant($variant_id)->minimum_quantity=$request->minimum_quantity;
         $product->variant($variant_id)->sku=$request->sku;

         if( $product-> variant($variant_id)->inventory()){
        $product-> variant($variant_id)->inventory()->stock=$request->stock;
        $product-> variant($variant_id)->inventory()->available=$request->stock;
        $product-> variant($variant_id)->inventory()->manufactured_date=$request->manufactured_date;
        $product-> variant($variant_id)->inventory()->expiry_date=$request->expiry_date;
        $product-> variant($variant_id)->inventory()->price=$request->price;
        $product-> variant($variant_id)->inventory()->cost=$request->cost;
         }else{
            Inventory::create([
                //"batch_id"=> null   ,
                "product_id"=>$product->id   ,
                "inventory_source_id"=>3  , //Manual
                "product_variant_id"=> $variant_id ,
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

         }


        // $product-> variant($variant_id)->discounts_variant->discount->discount_type->id= $request->discount_type_id;
        // $product-> variant($variant_id)->discounts_variant->discount->discount_apply->id=1;  // 1	Product       2	Category


        // return response()->json
        // ([
        // "is_null($request->discount_id)" => is_null($request->discount_id),
        // "isset($request->discount_id)"  =>isset($request->discount_id),
        // "empty($request->discount_id)"=>empty($request->discount_id),
        // "request->discount_id==undefined"=>($request->discount_id=="undefined")
        // ]);

/*
        if( isset($request->discount_id)&& $request->discount_id!="undefined")
        {
            $discountVariant=DiscountVariant::where("product_variant_id",$variant_id) ->first();

            if(!$discountVariant||  $discountVariant ==null )
            {

                $newDiscountVariant =  DiscountVariant::create([
                    "product_variant_id"=>  $variant_id,
                    "discount_id" =>$request->discount_id,
                    "companie_id"=> $product->companie_id,
                ]);


            }else{
                $product-> variant($variant_id)->discount_variant( $discountVariant->id)->discount_id =$request->discount_id;


            }
        }
*/

        $folder_companie=  $this->user->companie->folder_companie;

            $directory_imagen =($request->inventory_type_id==1) ?"companies/". $folder_companie ."/products/":
                "companies/". $folder_companie ."/products/".$product->id."/variants/". $variant_id."/";




        if($request->hasFile("imagen_file")){

            $nameFile=($request->inventory_type_id==1)? $request->sku.".jpg":$request->file("imagen_file")->getClientOriginalName();

            $path =($request->inventory_type_id==1)? Storage::putFileAs($directory_imagen ,$request->file("imagen_file"),$nameFile):
                                                        Storage::putFileAs($directory_imagen ,$request->file("imagen_file"),$nameFile);
            $request->request->add(["imagen" =>$nameFile]);
           // return response()->json(["message" =>$path]);

           $product->variant($variant_id)->image=$request->imagen;

        } else{
            $request->request->add(["imagen" =>  $product->variant($variant_id)->image]);
        }


        $product->push();


    //SI TRAE ARCHIVO DRAGEADO LO GUARDA EN CARPETA Y BASE DE DATOS

    $directory_images =($request->inventory_type_id==1)? "companies/". $folder_companie ."/products/".$product->id."/images/":
                         "companies/". $folder_companie ."/products/".$product->id."/variants/". $variant_id."/images/";



        if($request->hasFile("images_files")){

            foreach ($request->file("images_files")as $key => $file)
            {

                $productImage=ProductVariantImage::where("product_id", $product->id)->where("name",$file->getClientOriginalName())->first();

                // return response()->json(["productImage" => $productImage, "filename"=>$file->getClientOriginalName()]);

                if(!$productImage||  $productImage ==null   )
                {

                    $newProductImage =  ProductVariantImage::create([
                        "product_variant_id"=>  $product->variant($variant_id)->id,
                        "product_id" => $product->id,
                        "companie_id"=> $product->companie_id,
                         "name" =>$file->getClientOriginalName(),
                        "size" =>  $file->getSize(),
                        "type" => $file->getMimeType(),
                    ]);


                    Storage::putFileAs( $directory_images,$file, $file->getClientOriginalName());


                }else
                   Storage::putFileAs( $directory_images,$file, $productImage->name);
            }
        }





      //Borra fisicamente otros archivos que haya diferente de la imagen de portada, ya sea multiple o individual
      $vaBorrarFile[]=[];
        $storageFile = Storage::files($directory_imagen);
     foreach (str_replace($directory_imagen,'',$storageFile ) as $key => $stFile)
        {

            //RECORRE IMAGENES EXISTENTES EN EL SKU
            if( $request->imagen && ( $stFile  != $request->imagen ))
                {
                    if($stFile!="noimage.png")
                    {
                   $vaBorrarFile[ $key]=$stFile;
                    unlink(storage_path('app\\public\\'.str_replace('/','\\',$directory_imagen). $stFile));
                    }
                }
        }


    //  return response()->json([
    //         "directory_imagen"=>$directory_imagen,
    //         "storageFile"=>$storageFile,
    //         "stFile" => $stFile ,
    //         "request imagen"=>$request->imagen,
    //         "vaBorrarFile"=>$vaBorrarFile ]);



     //RECORRE PARA BORRAR FALTANTE (SI ES QUE SE BORRA EN APP ALGUNA IMAGES)


          $storageFiles = Storage::allFiles($directory_images);
          $miniImages= json_decode($request->images);



         // $nameMiniImages= array_column(array_column($miniImages,'file'),'name');
          $nameMiniImages= array_column($miniImages,'name');
          $ix=0;

         // $nameMiniImages= array_column($miniImages,'file');

          $vaBorrar[]=[];

          foreach (str_replace($directory_images,'',$storageFiles ) as $key => $stFile)
          {

              //RECORRE IMAGENES EXISTENTES EN EL SKU
              if(! in_array( $stFile  , $nameMiniImages ))
                  {
                   $prodImage= ProductVariantImage::where("name",$stFile)->first();
                     if($prodImage && $prodImage->id>0)
                     {
                        $prodImage->delete();
                     }
                     $vaBorrar[ $key]=$stFile;
                          unlink(storage_path('app\\public\\'.str_replace('/','\\',$directory_images). $stFile));
                  }
          }



        //Delete inexistent thumbails Images in BD
        foreach ( $product->variant($variant_id)->product_variant_images as $key => $prod_variant_image) {
            if(   !in_array( $prod_variant_image->name  , $nameMiniImages ) )
            {
                $prod_variant_image->delete();
            // return response()->json([
            //     "message" => $prod_variant_image->name ,"miniImages"=>$miniImages ]);

            }
        }



        return response()->json
        ([
        "message" => 200 ,
        "images"=>$request->images,
        "images_files"=>$request->file("images_files"),
        "storageFiles"=> $storageFiles,
        "miniImages"=>$miniImages,
        "nameMiniImages"=>$nameMiniImages,
        //"prodImage"=>$prodImage,
        "vaBorrar"=>$vaBorrar
        ]);

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productVariant=ProductVariant::findOrFail($id);
       // $brand->delete();
            // if($brand->imagen){
            //     Storage::delete($brand->imagen);
            // }
        // $brand->state_id=2;
        // $brand->save();
        $productVariant->delete();

        return  response()->json([
            "codeState"=>200,
            "codeMessage"=>"Success",
         //   "brand" => new BrandResource($brand)
        ]);
    }


    public function change_state(Request $request,$id)
    {
       //$state_id= $request->state_id;

        $product=Product::where("id",$id)->first();
        $product->state_id =$product->state->code==='Active'? 2:1;
        $product->save();

        return response()->json(["message"=>200,
       // "product" =>  ProductCollection::make($product)
      "product" => new ProductCResource($product->fresh()),
      // "product" => ProductCResource::make($product->fresh()),

        ]);

    }


    public function import(Request $request)
    {



      $companie_id= $this->user->companie->id;
      $subcategories = Subcategorie::where('companie_id', $companie_id )->orderBy("name","asc")->get();
      $brands = Brand::where('companie_id', $companie_id )->orderBy("name","asc")->get();
      $units = Unit::where('companie_id', $companie_id )->orderBy("name","asc")->get();
      $taxs = Tax::where('companie_id', $companie_id )->orderBy("code","asc")->get();
      $inventoryTypes = InventoryType::orderBy("code","asc")->get();
      $dimensions=ProductVariantDimension::where('companie_id', $companie_id )->orderBy("name","asc")->get();
      $attributes=ProductVariantAttribute::where('companie_id', $companie_id )->orderBy("name","asc")->get();

     // $req['code_inventory_type']=strtoupper($req['code_inventory_type']);


     //return response()->json(["res"=> $inventoryTypes]);
      $products= [];
      $dataProducts=[];
      $dataPreVariants=[]; //Price Image stock minimum_quantity  --- dimension and attribute
      $dataVariants=[];
      $dataInventory=[];


      foreach ($request ->all() as $key => $req) {

        //return response()->json(["key"=>  $req]);

        if ( isset($req['sku']) && $req['sku']!='')
        {

            $product= Product::create (        [
                "title"=> $req['title'],
                 "subcategorie_id" =>    $subcategories->where(  "code",$req['code_subcategorie'])->value('id') ,
                 "brand_id"=> $brands->where(  "code",$req['code_brand'])->value('id') ,
                "unit_id"=> $units->where(  "code",$req['code_unit'])->value('id') ,
                "tax_id"=> $taxs->where(  "code",$req['code_tax'])->value('id') ,
                "slug"=> $req['slug'],
               // "sku"=> $req['sku'],
                "tags"=> $req['tags'],
                "summary"=> $req['summary'],
                "description"=> $req['description'],
                "online"=>1,
                "companie_id"=>$companie_id,
                //"prodstate_id"=>1,
                "state_id"=>"1",
                "inventory_type_id"=> $inventoryTypes->where(  "code",$req['code_inventory_type'])->value('id')


                ] );



                if($req['code_inventory_type']==='INDIVIDUAL')
                {


                    $variant=       $product->variants()->create(
                        [
                        "cover"=>1,
                        "image"=>$req['sku'].".jpg",
                        "sku"=>$req['sku'],
                        "minimum_quantity"=> $req["minimum_quantity"],
                        "companie_id"=>$companie_id,
                        "product_variant_state_id"=>1,
                        "product_variant_attribute_id"=>null,
                        "product_variant_dimension_id"=>null
                         ]

                    );

            $inventory=$variant->inventories()->create(
                [
                    "batch_id"=> 1,//import file x
                    "store_id"=> $request['store_id'],
                    "provider_id"=> 1, //Sistem Myself
                    "product_id"=>$variant->product_id,
                    "stock"=> $req["stock"],
                    "manufactured_date"=>$req["manufactured_date"] ,
                    "expiry_date"=>$req["expiry_date"] ,
                    "price"=> $req["price"],
                    "cost"=>$req["cost"] ,
                    "companie_id"=> $companie_id,
                    "sold"=>0,
                    "available"=>$req["stock"],
                    "inventory_source_id"=>1  //import
                ]
            );


            }else  if($req['code_inventory_type']==='MULTIPLE'){

                $skus=explode(',', $req['sku']);
                $prices=explode(',', $req['price']);
                $minimums=explode(',', $req['minimum_quantity']);
                $stocks= explode(',', $req['stock']);
                $costs= explode(',', $req['cost']);
                $manufactured_dates= explode(',', $req['manufactured_date']);
                $expiry_dates= explode(',', $req['expiry_date']);

                $code_dimensions=explode(',',  $req['code_dimensions']);
                $code_attributes= explode(',', $req['code_attributes']);
                $n=count($prices);
                if(  count($minimums) ==$n & count($stocks) ==$n & count($code_dimensions) ==$n & count($code_attributes)==$n){

                    for ($i=0; $i <$n ; $i++) {

             $variant=    $product->variants()->create(
                            [
                            "cover"=>$i==0?1:0,
                            "image"=>$code_dimensions[$i]."_" . $code_attributes[$i].".jpg",
                            "sku"=> $skus[$i],
                            "minimum_quantity"=> $minimums[$i],
                            "companie_id"=>$companie_id,
                            "product_variant_state_id"=>1,
                            "product_variant_attribute_id"=> $attributes->where(  "code",$code_attributes[$i])->value('id') ,
                            "product_variant_dimension_id"=> $dimensions->where(  "code",$code_dimensions[$i])->value('id')
                             ]

                        );

                       // $inventory=$variant->inventories()->create(
                        $inventory=$variant->inventories()->create(
                            [
                                "batch_id"=> 1,//import file x
                                "product_id"=> $variant->product_id,
                                "inventory_source_id"=>1,  //import

                                "store_id"=> $request['store_id'],
                                "provider_id"=> 1, //Sistem Myself
                                "stock"=>  $stocks[$i],

                                "manufactured_date"=>$manufactured_dates[$i] ,
                                "expiry_date"=>$expiry_dates[$i],
                                "price"=>  $prices[$i],
                                "cost"=> $costs[$i] ,
                                "sold"=>0,
                                "available"=>$stocks[$i],
                                "companie_id"=> $companie_id

                            ]
                            );

                        }

                }


            }

          // return response()->json(["dataProducts"=> $products]);



         }
 }


       return response()->json(["dataVariants"=>   $dataVariants  ]);


    }



}
