<?php

namespace App\Http\Controllers\Ecommerce;

use Carbon\Carbon;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Discount\Discount;
use App\Models\Product\Categorie;
use App\Http\Controllers\Controller;
use App\Models\Companie;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\Ecommerce\Product\ProductHomeEcommerceCollection;
use App\Models\Product\Supercategorie;
use App\Http\Resources\Ecommerce\Product\SliderCollection;
use App\Http\Resources\Ecommerce\Product\Home\FlashProductHomeEcommerceCollection;
use App\Http\Resources\Ecommerce\Product\Home\TrendingProductHomeEcommerceCollection;
use App\Http\Resources\Ecommerce\Product\Home\LastProductHomeEcommerceCollection;
use App\Http\Resources\Ecommerce\Product\Home\NewArrivalsProductHomeEcommerceCollection;
use App\Http\Resources\Ecommerce\Product\Home\DeptoProductHomeEcommerceCollection;
use App\Models\Product\Variant\ProductVariant;
use App\Http\Resources\Ecommerce\Product\ProductVariantsHomeEcommerceCollection;

class HomeController extends Controller
{
    //

    //public function home(Request $request) {
        public function home(Request $request) {



            $companie_id=$request->companie_id??null;




            $companie = Companie::findOrFail( $companie_id);

       $companie_path_url= $companie->companie_path_url();
       $companie_path_public=$companie->companie_path_public() ;

/*
        $supercategories_randoms=Supercategorie::withCount(["product_supercategories"])
        ->inRandomOrder()->limit(5)->get();
*/



         if(! $companie){
            return response()->json([
                "message" => 401,
            ]);

         }




      /*  $sliders_principal = Slider::where("companie_id",  $companie_id)->where("state_id",1)->where("slider_type_id",1)->get();
        $banner_duo = Slider::where("companie_id",  $companie->id)->where("state_id",1)->where("slider_type_id",2)->get();
        $slider_products = Slider::where("companie_id",  $companie->id)->where("state_id",1)->where("slider_type_id",3)->get();
*/

$slider= Slider::where("companie_id",  $companie_id)->where("state_id",1)
                ->with('companie')
                ->get()
               ;



$sliders_principal =$slider->where("slider_type_id",1);
$banner_duo =$slider->where("slider_type_id",2);
$slider_products =$slider->where("slider_type_id",3);

/*

        $categories_randoms=  DB::table('categories as cat')
        ->join('subcategories as sub', 'sub.categorie_id', '=', 'cat.id')
        ->join('products as prod', 'prod.subcategorie_id', '=','sub.id')
        ->where('prod.companie_id',  $companie_id)->where('prod.state_id',1)
        ->groupBy('cat.name')
        ->inRandomOrder()->limit(5)
        ->get(['cat.id','cat.name','cat.imagen',  DB::raw('count(prod.id) as items')])
        ->map( function($cat) use( $companie_path_url, $companie_path_public)  {
            return
                 [
                    "id"=> $cat->id,
                   "name"=> $cat->name,
                   "products_count"=> $cat->items,

                  //"items_product"=> $cat->products(),
                  "imagen"=>
                  ( !empty($cat->imagen) &&  file_exists(  $companie_path_public  .'\\categories\\'.  $cat->imagen))?
                   $companie_path_url."/categories/".   $cat->imagen:
                   $companie_path_url ."/categories/" . "noimage.png"


                ];
         });
*/

         $categories_randoms= Categorie:: where("companie_id",  $companie_id)->where("state_id",1)
         ->withCount("products")
         ->inRandomOrder()
         ->having('products_count','>',0)
         ->limit(5)
         ->orderBy('products_count', 'desc')
         ->get()
         ->map( function($cat) use( $companie_path_url, $companie_path_public)  {
          //  ->map( function($cat)  {
            return
                 [
                     "id"=> $cat->id,
                   "name"=> $cat->name,
                   "products_count"=> $cat->products_count,
                     "imagen"=>
                  ( !empty($cat->imagen) &&  file_exists(  $companie_path_public  .'\\categories\\'.  $cat->imagen))?
                   $companie_path_url."/categories/".   $cat->imagen:
                   $companie_path_url ."/categories/" . "noimage.png",
                  //"items_product"=> $cat->products(),
                  "imagen"=>
                  ( !empty($cat->imagen) &&  file_exists(  $companie_path_public  .'\\categories\\'.  $cat->imagen))?
                   $companie_path_url."/categories/".   $cat->imagen:
                   $companie_path_url ."/categories/" . "noimage.png"


                ];
         });



        $trending_product_news = Product::where("companie_id",  $companie_id)->where("state_id",1)

        //->inRandomOrder()
        ->limit(8)
        ->with('companie', 'brand:id,name','inventory_type:id,code',
        'variant_cover.inventory',
       //'discount_products.discount','discount_categories','discount_subcategories','discount_brands'
          'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
        )
          ->get() ;


 //  return   $trending_product_news[0]->subcategorie->categorie->discount_categories;

     $trending_product_features = Product::where("companie_id",  $companie_id)->where("state_id",1)
       ->inRandomOrder()
       ->limit(8)
       ->with('companie', 'brand:id,name','inventory_type:id,code',
       'variant_cover.inventory',
          'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
       )->get() ;

        $trending_product_top_sellers = Product::where("companie_id",  $companie_id)->where("state_id",1)
       ->inRandomOrder()
       ->limit(8)
       ->with('companie', 'brand:id,name','inventory_type:id,code',
       'variant_cover.inventory',
          'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
       )->get() ;



        $products_depto_banner=Supercategorie::where("companie_id",  $companie_id)->where("state_id",1)
                                                -> where("id",1)
                                            //->inRandomOrder()->limit(1)
                                            ->with(['categories' => function( $query){
                                                    //$query->select('name');
                                                // $query->where("supercategorie_id",1);
                                                    $query->limit(6);

                                                }])
                                                ->get()
                                                ->map(function($sup){
                                                    return [
                                                        "id"=>$sup->id,
                                                        "name"=>$sup->name,
                                                        "categories"=>$sup->categories->map(function($cat){
                                                            return [
                                                                "name"=>$cat->name,
                                                            ];
                                                        })
                                                    ];
                                                })
                                                ->first();



        $supercategorie_id=  $products_depto_banner['id'];
        $products_depto=Product::where("companie_id",  $companie_id)->where("state_id",1)
                                ->whereHas("subcategorie",function($q1) use($supercategorie_id){
                                        $q1->whereHas("categorie",function($q2) use($supercategorie_id){
                                            $q2->where("supercategorie_id", $supercategorie_id );
                                        });
                                    })->limit(6)
                                    ->with('companie', 'brand:id,name','inventory_type:id,code',
                                    'variant_cover.inventory',
                                       'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
                                    )->get() ;

//return  $products_depto;


        $cat_randoms_ids=$categories_randoms->pluck("id");



                           $product_new_arrivals =Product::where("companie_id",  $companie_id)->where("state_id",1)
                        ->whereHas("subcategorie",function($q1) use( $cat_randoms_ids){
                                $q1->whereHas("categorie",function($q2) use( $cat_randoms_ids){
                                    $q2 ->whereIn("categorie_id", $cat_randoms_ids);
                                   // $q2->where("supercategorie_id", $supercategorie_id );
                                });
                            })->limit(6)
                            ->with('companie', 'brand:id,name','inventory_type:id,code',
                            'variant_cover.inventory',
                               'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
                            )->get() ;





                               $last_product_discounts = Product::where("companie_id",  $companie_id)->where("state_id",1)->inRandomOrder()->limit(3)
                               ->with('companie', 'brand:id,name','inventory_type:id,code',
                               'variant_cover.inventory',
                                  'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
                               )->get() ;

                                $last_product_features = Product::where("companie_id",  $companie_id)->where("state_id",1)->inRandomOrder()->limit(3)
                                ->with('companie', 'brand:id,name','inventory_type:id,code',
                                'variant_cover.inventory',
                                   'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
                                )->get() ;

                                $last_product_sellings = Product::where("companie_id",  $companie_id)->where("state_id",1)->inRandomOrder()->limit(3)
                                ->with('companie', 'brand:id,name','inventory_type:id,code',
                                'variant_cover.inventory',
                                   'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
                                )->get() ;


        date_default_timezone_set("America/Mexico_City");

       $discount_flash = Discount::where("companie_id",  $companie_id)->where("discount_method_id",2)->where("state_id",1)
                             ->select('id','start_date','end_date','code')
                             ->where("start_date","<=",today())
                              ->where("end_date",">=",today())
                             ->with('products:id','categories:id','brands:id')
                            ->first()
                             //->setHidden(['discount_apply_id','discount_type_id','discount_method_id','campaign_id','companie_id','state_id'])
                ;



        $discount_flash_products = collect([]);

        if($discount_flash){

        $discount_flash_products_ids=$discount_flash->products->pluck("id");

        $discount_flash_products =Product::whereIn("id", $discount_flash_products_ids)
           ->with('companie', 'brand:id,name','inventory_type:id,code',
            'variant_cover.inventory',
            //'discount_products.discount','subcategorie.discount_categories.discount','discount_brands.discount'
            'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
            )
            ->get();
        }



          $dataResponse=[


          "sliders_principal" =>  SliderCollection::make($sliders_principal),
      "categories_randoms"=> $categories_randoms,


       "trending_product_news" => ProductHomeEcommerceCollection::make($trending_product_news),
      "trending_product_features" => ProductHomeEcommerceCollection::make($trending_product_features),
        "trending_product_top_sellers" => ProductHomeEcommerceCollection::make($trending_product_top_sellers),

        "banner_duos" =>   SliderCollection::make($banner_duo) ,


       "discount_flash" => $discount_flash,
       "discount_flash_products" => FlashProductHomeEcommerceCollection::make($discount_flash_products),

      "slider_products" => SliderCollection::make($slider_products),

        "products_depto" => ProductHomeEcommerceCollection::make($products_depto),
        "products_depto_banner"=>$products_depto_banner,
        "product_new_arrivals" =>ProductHomeEcommerceCollection::make($product_new_arrivals),

        "last_product_discounts" => ProductHomeEcommerceCollection::make($last_product_discounts),
        "last_product_features" => ProductHomeEcommerceCollection::make($last_product_features),
        "last_product_sellings" =>ProductHomeEcommerceCollection::make($last_product_sellings),

        ];


       // return  $dataResponse;
      // return ['data'=> $dataResponse];

        //return "xx";
    return response()->json( $dataResponse);
     //return view('welcome',['data'=> $dataResponse]);
    // return view('test',['data'=> $dataResponse]);

    }

    public function menus(Request $request) {



           $companie_id=$request->companie_id??null;


            $companie = Companie::findOrFail( $companie_id);
            $companie_path_url= $companie->companie_path_url();
            $companie_path_public=$companie->companie_path_public() ;



          // $categories_randoms = Categorie::withCount(["product_categorie_firsts"]);

            // $supercategories_randoms=Supercategorie::withCount(["product_supercategories"])
            // ->inRandomOrder()->limit(5)->get();




             if(!$companie){
                return response()->json([
                    "message" => 401,
                ]);

             }


        $supercategories_menus = Supercategorie::where("companie_id",$companie_id)
                            ->where("state_id",1)
                            ->with("categories.subcategories")
                            //->orderBy("name","desc")
                            ->get();



      /*  return response()->json([
                    "supercategorie_menus"=>$supercategories_menus
        ]);
*/


      return response()->json([
            "supercategorie_menus" => $supercategories_menus ->map(function($supercat)use( $companie_path_url, $companie_path_public) {
                return [
                    "id" => $supercat->id,
                    "name" => $supercat->name,
                    "icon"=>     ($supercat->icon)? $supercat->icon:
                    '<svg fill="#000000" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                        <path d="M960 1807.059c-467.125 0-847.059-379.934-847.059-847.059 0-467.125 379.934-847.059 847.059-847.059 467.125 0 847.059 379.934 847.059 847.059 0 467.125-379.934 847.059-847.059 847.059M960 0C430.645 0 0 430.645 0 960s430.645 960 960 960 960-430.645 960-960S1489.355 0 960 0" fill-rule="evenodd"/>
                    </svg>',
                    "categories" => $supercat->categories->take(5)->map(function($categorie,$key) use( $companie_path_url, $companie_path_public) {

                        return [
                            "id" => $categorie->id,
                            "name" => $categorie->name,
                            //"imagen" => $categorie->imagen ? env("APP_URL")."storage/".$categorie->imagen : NULL,
                            "imagen"=>
                            ( !empty($categorie->imagen) &&  file_exists(  $companie_path_public  .'\\categories\\'.  $categorie->imagen))?
                             $companie_path_url."/categories/".   $categorie->imagen:
                             $companie_path_url ."/categories/" . "noimage.png",
                            "subcategories" => $categorie->subcategories->take(5)->map(function($subcategorie,$key2) use( $companie_path_url, $companie_path_public) {

                                return  [
                                    "id" => $subcategorie->id,
                                    "name" => $subcategorie->name,
                                    "imagen"=>
                                    ( !empty($subcategorie->imagen) &&  file_exists(  $companie_path_public  .'\\subcategories\\'.  $subcategorie->imagen))?
                                     $companie_path_url."/subcategories/".   $subcategorie->imagen:
                                     $companie_path_url ."/subcategories/" . "noimage.png",
                                ];
                            })
                        ];
                    })
                ];
            }),
        ]);




    }



    public function show_product_slug(Request $request, $slug)
    {

        $code_discount= $request->get("campaing_discount");

        $discount=null;
        if( $code_discount){
          $discount=Discount::where("code",$code_discount)
          ->whereDate('start_date', '<=', date("Y-m-d"))
          ->whereDate('end_date', '>=', date("Y-m-d"))
          ->first();
        }

        $product = Product::where("slug",$slug)->where("state_id",1)
        ->with('subcategorie','subcategorie.categorie','subcategorie.categorie.supercategorie:id,name')
        ->with('companie', 'brand:id,name','inventory_type:id,code',
        'variant_cover.inventory',
        'variants','dimensions','attributes',
         //  'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
         'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'

        )
        ->with('variants.product_variant_dimension','variants.product_variant_attribute')
        ->with('specifications.attribute')
        ->get();






   //return $product;

         if(!$product || $product=='[]'){
            return response()->json([
                "message"=>403,
                "message_text"=> "El Producto No existe"
            ]);
         }

        // $product= $product[0];


       //$product_relateds = Product::where("subcategorie_id",   $product[0]->subcategorie_id)->where("state_id",1)
       $product_relateds = Product::where("state_id",1)
        //->inRandomOrder()
        ->limit(8)
        ->with('companie', 'brand:id,name','inventory_type:id,code',
        'variant_cover.inventory',
        //   'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
        'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'

        )->get() ;




        return response()->json(
            [
                "message"=>200,
            "product" =>   ProductVariantsHomeEcommerceCollection::make($product),
            "product_relateds"=> ProductHomeEcommerceCollection::make($product_relateds ),
            "discount_campaign"=> $discount
            ]
        );




    }
    public function show_product_details($id)
    {

        $product = Product::where("id","=", $id)
        ->with('companie', 'brand:id,name','inventory_type:id,code',
        'variant_cover.inventory',
        'variants',
           'discount_products.discount','subcategorie.discount_subcategories.discount','subcategorie.categorie.discount_categories.discount'
        )
        ->get()
        ;




        return response()->json(
            [
            "product_details" => ProductVariantsHomeEcommerceCollection::make($product),
            ]
        );




    }


}
