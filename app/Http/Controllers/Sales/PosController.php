<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale\Sale;
use App\Models\Product\Categorie;
use App\Models\People\Store;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Product\Tax;
use App\Models\Product\Reduction;
use App\Models\Product\Shipping;
use App\Models\Discount\Discount;
use Carbon\Carbon;
use App\Http\Resources\Product\POSCollection;


class PosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function info(Request $request)
    {

        $store_id =$request->store_id;

        $user=auth()->user();

        $companie_id= $user->companie_id;

        $companie_path_url=  $user->companie_path_url();
        $companie_path_public= $user->companie_path_public() ;



        //$categories=Categorie::Where("companie_id", $companie_id  )->orderBy("id","desc")->get();

        $taxes= Tax::Where("store_id",$request['store_id']  )->orderBy("id","desc")->get();
        if(count ($taxes)==0)
        $taxes=Tax::Where("companie_id", $companie_id  )->Where("store_id",null  )->orderBy("id","desc")->get();


        $reductions= Reduction::Where("store_id",$request['store_id']  )->orderBy("id","desc")->get();
        if(count ($reductions)==0)
        $reductions=Reduction::Where("companie_id", $companie_id  )->Where("store_id",null  )->orderBy("id","desc")->get();



        $shippings= Shipping::Where("store_id",$request['store_id']  )->orderBy("id","desc")->get();
        if(count ($shippings)==0)
        $shippings=Shipping::Where("companie_id", $companie_id  )->Where("store_id",null  )->orderBy("id","asc")->get();



        return response()->json([
        "orders"=>null,
        "taxes"=>$taxes,
        "shippings"=>$shippings,
        "reductions"=>$reductions,

        ]);


    }

    public function categories()
    {

        $user=auth()->user();

        $companie_id= $user->companie_id;

        $companie_path_url=  $user->companie_path_url();
        $companie_path_public= $user->companie_path_public() ;


        $categories= Categorie:: where("companie_id",  $companie_id)
        ->where("state_id",1)
        ->withCount("products")
        //->inRandomOrder()
        ->having('products_count','>',0)
        ->limit(6)
        ->orderBy('products_count', 'desc')
        ->get()
        ->map( function($cat) use( $companie_path_url, $companie_path_public)  {
         //  ->map( function($cat)  {
           return
                [
                    "id"=> $cat->id,
                  "name"=> $cat->name,
                  "items"=> $cat->products_count,
                    "imagen"=>
                 ( !empty($cat->imagen) &&  file_exists(  $companie_path_public  .'\\categories\\'.  $cat->imagen))?
                 [
                   "url"=> $companie_path_url."/categories/".   $cat->imagen
                 ]
                  :
                  [
                  "url"=> $companie_path_url ."/categories/" . "noimage.png"
                  ],

                 //"items_product"=> $cat->products(),
                 "imagen"=>
                 ( !empty($cat->imagen) &&  file_exists(  $companie_path_public  .'\\categories\\'.  $cat->imagen))?
                 [
                  "url"=>$companie_path_url."/categories/".   $cat->imagen
                 ]

                  :
                  [
                  "url"=>  $companie_path_url ."/categories/" . "noimage.png"
                  ]


               ];
        })
        ;
      //return $categories;


        return response()->json([
        "categories"=>$categories,
      /* "categories"=>DB::table('categories as cat')
        ->join('subcategories as sub', 'sub.categorie_id', '=', 'cat.id')
        ->join('products as prod', 'prod.subcategorie_id', '=','sub.id')
        ->groupBy('cat.name')
        ->get(['cat.id','cat.name','cat.imagen',  DB::raw('count(prod.id) as items')])
        ->map( function($cat) use( $companie_path_url, $companie_path_public)  {
            return
                 [
                    "id"=> $cat->id,
                   "name"=> $cat->name,
                   "items"=> $cat->items,

                  //"items_product"=> $cat->products(),
                  "imagen"=>
                  ( !empty($cat->imagen) &&  file_exists(  $companie_path_public  .'\\categories\\'.  $cat->imagen))?
                   [
                        "url"=>  $companie_path_url."/categories/".   $cat->imagen ,
                       "name"=>    $cat->imagen ,
                       "size"=>  (string)filesize(  $companie_path_public ."\\categories\\".  $cat->imagen )
                   ] :
                   [
                   "url"=> $companie_path_url ."/categories/" . "noimage.png",
                   "name"=>  $cat->imagen ,
                   "size"=> (string) filesize( $companie_path_public ."\\categories\\" . "noimage.png")
                   ],

               //   "products"=> $cat ,

                ];
         })*/

        ]);


    }



    public function index(Request $request)
    {


        $page=$request->page??1;
        $store_id =$request->store_id;

       $pageSize=$request->page_size??3;


        $store = Store::where(  "id", $store_id)->with('companie')->first();
        $companie_id= $store->companie->id;
        $search = $request->search;
        $supercategorie_id = $request->supercat_id;
        $categorie_id = $request->cat_id;
        $subcategorie_id = $request->subcat_id;
        $brand_id=$request->brand_id;
        $unit_id=$request->unit_id;
        $state_id=$request->state_id;


/*
        $categories=Categorie::Where("companie_id", $companie_id  )->orderBy("id","desc")->get();

        $taxes= Tax::Where("store_id",$request['store_id']  )->orderBy("id","desc")->get();
        if(count ($taxes)==0)
        $taxes=Tax::Where("companie_id", $companie_id  )->Where("store_id",null  )->orderBy("id","desc")->get();


        $reductions= Reduction::Where("store_id",$request['store_id']  )->orderBy("id","desc")->get();
        if(count ($reductions)==0)
        $reductions=Reduction::Where("companie_id", $companie_id  )->Where("store_id",null  )->orderBy("id","desc")->get();



        $shippings= Shipping::Where("store_id",$request['store_id']  )->orderBy("id","desc")->get();
        if(count ($shippings)==0)
        $shippings=Shipping::Where("companie_id", $companie_id  )->Where("store_id",null  )->orderBy("id","asc")->get();
*/


         $products = Product::filterProduct($companie_id,$supercategorie_id , $categorie_id , $subcategorie_id, $brand_id, $unit_id,  $state_id,$search )
        ->orderBy("id","desc")
        ->with('companie', 'brand:id,name','inventory_type:id,code',
         //'discounts',
         //'discount_apply',//'discount_type','discount_method',
         'variant_cover.inventory',
         'discount_products.discount','discount_categories.discount','discount_brands.discount'
        )->with('variant_cover.product_variant_state')
        ->with('variant_cover.product_variant_attribute')
        ->with('variant_cover.product_variant_dimension')
         ->paginate($pageSize)
         ;




      //   $product->folder_companie= $this->user->companie->folder_companie;


        // return $products;

        // $total=count($products);

         //$products = $products ->take(   $limitToShow);
        //return ProductCCollection::make($products);

        $user=auth()->user();
        $companie_path_url=  $user->companie_path_url();
        $companie_path_public= $user->companie_path_public() ;





        return response()->json([
            //"message" => 200,
            // "total" => $products->total(),
            // "products" => ProductCCollection::make($products),
           "totalData"=> $products->total() ,
            "data"=>  POSCollection::make($products),




        ]);



    }

    public function products(Request $request)
    {
        $store = Store::where(  "id",$request['store_id'])->with('companie')->first();
        $companie_id= $store->companie->id;
        $search = $request->search;
        $supercategorie_id = $request->supercat_id;
        $categorie_id = $request->cat_id;
        $subcategorie_id = $request->subcat_id;
        $brand_id=$request->brand_id;
        $unit_id=$request->unit_id;
        $state_id=$request->state_id;



        $categories=Categorie::Where("companie_id", $companie_id  )->orderBy("id","desc")->get();



         $products = Product::filterProduct($companie_id,$supercategorie_id , $categorie_id , $subcategorie_id, $brand_id, $unit_id,  $state_id,$search )->orderBy("id","desc")->get();

      //   $product->folder_companie= $this->user->companie->folder_companie;


        // return $products;

        // $total=count($products);

         //$products = $products ->take(   $limitToShow);
        //return ProductCCollection::make($products);

        $user=auth()->user();
        $companie_path_url=  $user->companie_path_url();
        $companie_path_public= $user->companie_path_public() ;



        return response()->json([

            "data"=> $products->map( function($prod) use($companie_path_url, $companie_path_public){

                return [
                "id"=>$prod->id,
                "title"=>$prod->title,

              "categorie" =>   [

                    "id" => $prod->subcategorie->categorie->id,
                        "name" => $prod->subcategorie->categorie->name,

                    ],
                    "subcategorie" =>   [

                        "id" => $prod->subcategorie->id,
                        "name" => $prod->subcategorie->name,

                    ],
                    "brand"=>[

                        "id" => $prod->brand->id??0,
                        "name" => $prod->brand->name??'',

                    ],
                    "unit"=>[

                        "id" => $prod->unit->id,
                        "name" => $prod->unit->name,

                    ],



                    "inventory_type"=>[

                        "id" => $prod->inventory_type->id,
                        "code" => $prod->inventory_type->code,

                    ],

                    "variants"=>$prod->variants-> map( function($var )use( $companie_path_url, $companie_path_public)  {

                        return [
                        // "product_variant_attribute_id"=>  $var->product_variant_attribute_id,
                        // "product_variant_dimension_id"=>   $var->product_variant_dimension_id,
                        "id"=>$var->id,
                        "dimension"=>($var->product_variant_dimension_id)?$var->product_variant_dimension->name:null,
                        "attribute"=>($var->product_variant_attribute_id)? $var->product_variant_attribute->name:null,
                        "cover"=>  $var->cover,
                        "minimum_quantity"=>  $var->minimum_quantity,
                        "sku"=>  $var->sku,

                    "imagen"=>
                    // if($var->product->inventory_type->code=='INDIVIDUAL')

                    ($var->product->inventory_type->code=='INDIVIDUAL')?
                            file_exists(  $companie_path_public  .'\\products\\'.      $var->image  )?
                                [
                                        "cover"=>$var->cover ,
                                        "url"=>  $companie_path_url."/products/".     $var->image ,
                                    "name"=>    $var->image ,
                                    "size"=>  (string)filesize(  $companie_path_public ."\\products\\".   $var->image )

                                ] :
                                [
                                "cover"=>$var->cover ,
                                "url"=> $companie_path_url ."/products/" . "noimage.png",
                                "name"=>  $var->name ,
                                "size"=> (string) filesize( $companie_path_public ."\\products\\" . "noimage.png")
                                ]
                        :

                            (  file_exists(  $companie_path_public  .'\\products\\'.   $var->product_id. "\\variants\\". $var->id."\\"  .$var->image  )?
                            [
                            "cover"=>$var->cover ,
                                "url"=>  $companie_path_url."/products/".   $var->product_id. "/variants/". $var->id."/"  .$var->image ,
                                "name"=>    $var->image ,
                                "size"=>  (string)filesize(  $companie_path_public .'\\products\\'.   $var->product_id. "\\variants\\". $var->id."\\"  .$var->image  )
                            ] :
                            [
                            "cover"=>$var->cover ,
                            "url"=> $companie_path_url ."/products/" . "noimage.png",
                            "name"=>   $var->name  ,
                            "size"=> (string) filesize( $companie_path_public ."\\products\\" . "noimage.png")
                            ]
                            )


                    ,
                    "product_variant_state"=>[

                        "id" => $var->product_variant_state->id,
                        "code" => $var->product_variant_state->code,
                        "name" => $var->product_variant_state->name,

                    ],
                    "inventory"=> ($var->inventory())?
                            [
                            //$var->inventory()->first()
                                "batch"=>$var->inventory()->first()->batch,
                                "price"=>$var->inventory()->first()->price,
                                "cost"=>$var->inventory()->first()->cost,
                                "stock"=>$var->inventory()->first()->stock,
                                "available"=>$var->inventory()->first()->available,
                                "manufactured_date"=>$var->inventory()->first()->manufactured_date,
                                "expiry_date"=>$var->inventory()->first()->expiry_date,
                            ]:null,

                        "discount_variant"=> $var->getDiscountVariantAttribute()?
                        [
                            "id"=>$var->getDiscountVariantAttribute()->id,
                            "code"=>$var->getDiscountVariantAttribute()->code,
                            "discount_type"=>
                            [
                                    "id" =>$var->getDiscountVariantAttribute()->discount_type->id,
                                    "code" =>$var->getDiscountVariantAttribute()->discount_type->code,
                            ],
                            "value"=>$var->getDiscountVariantAttribute()->discount,
                        ]:null



                    ];

                    }),

                    ];

            })//TERMINA
            ,

        ]);


    }
}
