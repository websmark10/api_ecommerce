<?php

namespace App\Http\Controllers\Discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount\Discount;

use App\Models\Discount\DiscountProduct;
use App\Models\Discount\DiscountCategorie;

use App\Models\Discount\Campaign;
use App\Models\Discount\DiscountType;
use App\Models\Discount\DiscountApply;
use App\Models\Product\Product;
use App\Models\Product\Categorie;
use App\Models\Product\Brand;
use App\Models\Discount\DiscountBrand;
use App\Models\Discount\CampaignType;
use App\Models\Discount\DiscountMethod;
use App\Http\Resources\Discount\DiscountCollection;
use App\Http\Resources\Discount\DiscountResource;
use App\Models\Product\State;


class DiscountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }



    public function info(){



        $user=auth()->user();



       $companie_id= $user->companie_id;

       $campaigns =Campaign::Where("companie_id", $companie_id )->Where("state_id",1)->get();

       $campaign_types =CampaignType:: Where("state_id",1)->get();

      $discount_methods=DiscountMethod:: Where("state_id",1)->get();

       $discount_types=DiscountType::Where("state_id",1)->get();

       $discount_applys=DiscountApply::Where("state_id",1)->get();

       $states=State::get();


/*
       $products = Product::where("state_id",1)->orderBy("id","desc")->get();

        $categories = Categorie::where("state_id",1)
                                // ->where("categorie_second_id",NULL)
                                // ->where("categorie_third_id",NULL)
                                ->orderBy("id","desc")->get();

        $brands = Brand::where("state_id",1)->orderBy("id","desc")->get();
*/
        return response()->json([
           "campaigns"=>$campaigns,
           "discount_methods"=>$discount_methods,
           "discount_types"=>$discount_types,
           "discount_applys"=>$discount_applys,
           "states"=>$states,
           // "products"=>$products,
            //"categories"=> $categories,
           // "brands"=>$brands
        ]);
    }

    public function info_list(){



        $user=auth()->user();



       $companie_id= $user->companie_id;

       $campaigns =Campaign::Where("companie_id", $companie_id )->Where("state_id",1)->get();


       $states=State::get();


        return response()->json([
           "campaigns"=>$campaigns,
           "states"=>$states,
        ]);
    }
    public function index()
    {


        $discounts = Discount::orderBy("id","desc")->paginate(25);

        return response()->json([
            "totalData" => $discounts->total(),
             "data" => DiscountCollection::make($discounts->setHidden([
                'created_at', 'updated_at', 'deleted_at'
            ])),
            //"discounts" => DiscountResource::make($discounts),
        ]);

    }

    public function products_autocomplete(Request $request)
    {

        $search = $request->search;
        $user=auth()->user();
        $companie_id= $user->companie->id;
        $products = Product::filterProduct($companie_id, null,null,null,null,null,null,$search )->take(50)->orderBy("id","desc")->get();

        return response()->json([
            "totalData" => count($products),
             "data"=> $products->map( function($prod){
                 return [
                    "id"=> $prod->id,
                    "title"=>$prod->title,
                   //"imagen"=> $prod->image_url_cover(),
                 ];
             })
            ]);

    }

    public function brands_autocomplete(Request $request)
    {

        $search = $request->search;
        $user=auth()->user();
        $companie_id= $user->companie->id;
        $brands = Brand::filterBrand($companie_id, null,$search )->take(50)->orderBy("id","desc")->get();

        return response()->json([
            "totalData" => count($brands),
             "data"=> $brands->map( function($brand){
                 return [
                    "id"=> $brand->id,
                    "name"=>$brand->name,
                    "imagen"=> $brand->imagen(),
                 ];
             })
            ]);

    }

    public function categories_autocomplete(Request $request)
    {

        $search = $request->search;
        $user=auth()->user();
        $companie_id= $user->companie->id;
        $categories = Categorie::filterCategorie($companie_id,null,$search )->take(50)->orderBy("id","desc")->get();

        return response()->json([
            "totalData" => count($categories),
             "data"=> $categories->map( function($cat){
                 return [
                    "id"=> $cat->id,
                    "name"=>$cat->name,
                    "imagen"=> $cat->imagen(),
                 ];
             })
            ]);

    }


    public function list(Request $request)
    {



        $page=$request->page??1;
        $pageSize=$request->page_size??10;
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        $search=$request->search;
        $state_id=$request->state_id??null;

        $user=auth()->user();
        $companie_id= $user->companie->id;


       $discounts = Discount::filter($companie_id,$state_id,$start_date,$end_date,$search)
                              //->orderBy("id","desc")
                              ->withCount(['products'])
                              ->with(['products' => function( $query){
                               $query->select('title','slug')->limit(10);
                            }])
                            ->withCount(['categories'])
                              ->with(['categories' => function( $query){
                               $query->select('name');
                                $query->limit(10);
                            }])
                            ->withCount(['brands'])
                              ->with(['brands' => function( $query){
                                $query->select('name') ->limit(10);
                            }])->with('discount_type','discount_method','discount_apply','discount_method','campaign')
                              ->paginate($pageSize)
                            //  ->setHidden(['campaign_id','discount_apply_id','discount_type_id','discount_method_id'])
                            ;


       return $discounts;

        return response()->json([
            "totalData" => $discounts->total(),
             "data" => DiscountCollection::make($discounts->setHidden([
                        'created_at', 'updated_at', 'deleted_at'
                        ])),
            //"discounts" => DiscountResource::make($discounts),
        ]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ES VALIDAR QUE LOS PRODUCTOS O CATEGORI O MARCAS NO SE REGISTREN DENTRO DEL MISMO
        // PERIODO DE TIEMPO
        // START_DATE Y END_DATE
        // discount_type_id / EL TIPO DE SEGMENTACIÓN QUE TIENE LA CAMPAÑA
        // product_selected / categorie_selected / brand_selected
        // campaign_id
        $user=auth()->user();
        $companie_id= $user->companie->id;
        $request->request->add(["companie_id" =>$companie_id]);


        if($request->discount_type_id == 1){//VALIDACION A NIVEL DE PRODUCTOS
            foreach ($request->product_selected as $key => $product_selected) {

                //return $product_selected;
                $EXIST_DISCOUNT_START_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        //->where("campaign_type_id",$request->campaign_type_id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_products",function($q) use($product_selected) {
                                                            $q->where("product_id",$product_selected["id"]);
                                                        })->whereBetween("start_date",[$request->start_date,$request->end_date])
                                                        ->first();
                $EXIST_DISCOUNT_END_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        //->where("campaign_type_id",$request->campaign_type_id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_products",function($q) use($product_selected) {
                                                            $q->where("product_id",$product_selected["id"]);
                                                        })->whereBetween("end_date",[$request->start_date,$request->end_date])
                                                        ->first();

                if($EXIST_DISCOUNT_START_DATE || $EXIST_DISCOUNT_END_DATE){

                    return response()->json(["message" => 403,"message_text" => "EL PRODUCTO ".$product_selected["title"].
                    " YA SE ENCUENTRA EN UNA CAMPAÑA DE DESCUENTO QUE SERIA ".($EXIST_DISCOUNT_START_DATE ? '#'.$EXIST_DISCOUNT_START_DATE->code : '')
                    .($EXIST_DISCOUNT_END_DATE ? '#'.$EXIST_DISCOUNT_END_DATE->code : '')]);
                }
            }
        }

        if($request->discount_type_id == 2){//VALIDACION A NIVEL DE CATEGORIA
            foreach ($request->categorie_selected as $key => $categorie_selected) {
                $EXIST_DISCOUNT_START_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        //->where("campaign_type_id",$request->campaign_type_id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_categories",function($q) use($categorie_selected) {
                                                            $q->where("categorie_id",$categorie_selected["id"]);
                                                        })->whereBetween("start_date",[$request->start_date,$request->end_date])
                                                        ->first();
                $EXIST_DISCOUNT_END_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        //->where("campaign_type_id",$request->campaign_type_id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_categories",function($q) use($categorie_selected) {
                                                            $q->where("categorie_id",$categorie_selected["id"]);
                                                        })->whereBetween("end_date",[$request->start_date,$request->end_date])
                                                        ->first();

                if($EXIST_DISCOUNT_START_DATE || $EXIST_DISCOUNT_END_DATE){

                    return response()->json(["message" => 403,"message_text" => "LA CATEGORIA ".$categorie_selected["name"].
                    " YA SE ENCUENTRA EN UNA CAMPAÑA DE DESCUENTO QUE SERIA ".($EXIST_DISCOUNT_START_DATE ? '#'.$EXIST_DISCOUNT_START_DATE->code : '')
                    .($EXIST_DISCOUNT_END_DATE ? '#'.$EXIST_DISCOUNT_END_DATE->code : '')]);
                }
            }
        }

        if($request->discount_type_id == 3){//VALIDACION A NIVEL DE MARCAS
            foreach ($request->brand_selected as $key => $brand_selected) {
                $EXIST_DISCOUNT_START_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        //->where("campaign_type_id",$request->campaign_type_id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_brands",function($q) use($brand_selected) {
                                                            $q->where("brand_id",$brand_selected["id"]);
                                                        })->whereBetween("start_date",[$request->start_date,$request->end_date])
                                                        ->first();
                $EXIST_DISCOUNT_END_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                       //->where("campaign_type_id",$request->campaign_type_id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_brands",function($q) use($brand_selected) {
                                                            $q->where("brand_id",$brand_selected["id"]);
                                                        })->whereBetween("end_date",[$request->start_date,$request->end_date])
                                                        ->first();

                if($EXIST_DISCOUNT_START_DATE || $EXIST_DISCOUNT_END_DATE){

                    return response()->json(["message" => 403,"message_text" => "LA MARCA ".$brand_selected["name"].
                    " YA SE ENCUENTRA EN UNA CAMPAÑA DE DESCUENTO QUE SERIA ".($EXIST_DISCOUNT_START_DATE ? '#'.$EXIST_DISCOUNT_START_DATE->code : '')
                    .($EXIST_DISCOUNT_END_DATE ? '#'.$EXIST_DISCOUNT_END_DATE->code : '')]);
                }
            }
        }

        $request->request->add(["code" => uniqid()]);
        $discount = Discount::create($request->all());

        foreach ($request->product_selected as $key => $product_selec) {
            DiscountProduct::create([
                "discount_id" => $discount->id,
                "product_id" => $product_selec["id"],
                "companie_id"=>$companie_id
            ]);
        }

        foreach ($request->categorie_selected as $key => $categorie_selec) {
            DiscountCategorie::create([
                "discount_id" => $discount->id,
                "categorie_id" => $categorie_selec["id"],
                "companie_id"=>$companie_id
            ]);
        }

        foreach ($request->brand_selected as $key => $brand_selec) {
            DiscountBrand::create([
                "discount_id" => $discount->id,
                "brand_id" => $brand_selec["id"],
                "companie_id"=>$companie_id
            ]);
        }



        $discount_added = Discount::findOrFail( $discount->id);



        return response()->json(["message" => 200,
        "discount"=> //$discount_added
        // DiscountCollection::make( $discount_added->setHidden(['created_at', 'updated_at', 'deleted_at' ])),
        DiscountResource::make($discount_added),
         ]);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {

        $discount = Discount::findOrFail($id);

        return response()->json([
            "discount" => DiscountResource::make($discount),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // ES VALIDAR QUE LOS PRODUCTOS O CATEGORI O MARCAS NO SE REGISTREN DENTRO DEL MISMO
        // PERIODO DE TIEMPO
        // START_DATE Y END_DATE
        // discount_type_id / EL TIPO DE SEGMENTACIÓN QUE TIENE LA CAMPAÑA
        // product_selected / categorie_selected / brand_selected
        // campaign_id


        $user=auth()->user();
        $companie_id= $user->companie->id;

        if($request->discount_type_id == 1){//VALIDACION A NIVEL DE PRODUCTOS
            foreach ($request->product_selected as $key => $product_selected) {


                $EXIST_DISCOUNT_START_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        ->where("id","<>",$id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_products",function($q) use($product_selected) {
                                                            $q->where("product_id",$product_selected["id"]);
                                                        })->whereBetween("start_date",[$request->start_date,$request->end_date])
                                                        ->first();
                $EXIST_DISCOUNT_END_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        ->where("id","<>",$id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_products",function($q) use($product_selected) {
                                                            $q->where("product_id",$product_selected["id"]);
                                                        })->whereBetween("end_date",[$request->start_date,$request->end_date])
                                                        ->first();

                if($EXIST_DISCOUNT_START_DATE || $EXIST_DISCOUNT_END_DATE){

                    return response()->json(["message" => 403,"message_text" => "EL PRODUCTO ".$product_selected["title"].
                    " YA SE ENCUENTRA EN UNA CAMPAÑA DE DESCUENTO QUE SERIA ".($EXIST_DISCOUNT_START_DATE ? '#'.$EXIST_DISCOUNT_START_DATE->code : '')
                    .($EXIST_DISCOUNT_END_DATE ? '#'.$EXIST_DISCOUNT_END_DATE->code : '')]);
                }
            }
        }

        if($request->discount_type_id == 2){//VALIDACION A NIVEL DE CATEGORIA
            foreach ($request->categorie_selected as $key => $categorie_selected) {
                $EXIST_DISCOUNT_START_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        ->where("id","<>",$id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_categories",function($q) use($categorie_selected) {
                                                            $q->where("categorie_id",$categorie_selected["id"]);
                                                        })->whereBetween("start_date",[$request->start_date,$request->end_date])
                                                        ->first();
                $EXIST_DISCOUNT_END_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        ->where("id","<>",$id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_categories",function($q) use($categorie_selected) {
                                                            $q->where("categorie_id",$categorie_selected["id"]);
                                                        })->whereBetween("end_date",[$request->start_date,$request->end_date])
                                                        ->first();

                if($EXIST_DISCOUNT_START_DATE || $EXIST_DISCOUNT_END_DATE){

                    return response()->json(["message" => 403,"message_text" => "LA CATEGORIA ".$categorie_selected["name"].
                    " YA SE ENCUENTRA EN UNA CAMPAÑA DE DESCUENTO QUE SERIA ".($EXIST_DISCOUNT_START_DATE ? '#'.$EXIST_DISCOUNT_START_DATE->code : '')
                    .($EXIST_DISCOUNT_END_DATE ? '#'.$EXIST_DISCOUNT_END_DATE->code : '')]);
                }
            }
        }

        if($request->discount_type_id == 3){//VALIDACION A NIVEL DE MARCAS
            foreach ($request->brand_selected as $key => $brand_selected) {
                $EXIST_DISCOUNT_START_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        ->where("id","<>",$id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_brands",function($q) use($brand_selected) {
                                                            $q->where("brand_id",$brand_selected["id"]);
                                                        })->whereBetween("start_date",[$request->start_date,$request->end_date])
                                                        ->first();
                $EXIST_DISCOUNT_END_DATE = Discount::where("campaign_id",$request->campaign_id)
                                                        ->where("id","<>",$id)
                                                        ->where("discount_type_id",$request->discount_type_id)
                                                        ->whereHas("discount_brands",function($q) use($brand_selected) {
                                                            $q->where("brand_id",$brand_selected["id"]);
                                                        })->whereBetween("end_date",[$request->start_date,$request->end_date])
                                                        ->first();

                if($EXIST_DISCOUNT_START_DATE || $EXIST_DISCOUNT_END_DATE){

                    return response()->json(["message" => 403,"message_text" => "LA MARCA ".$brand_selected["name"].
                    " YA SE ENCUENTRA EN UNA CAMPAÑA DE DESCUENTO QUE SERIA ".($EXIST_DISCOUNT_START_DATE ? '#'.$EXIST_DISCOUNT_START_DATE->code : '')
                    .($EXIST_DISCOUNT_END_DATE ? '#'.$EXIST_DISCOUNT_END_DATE->code : '')]);
                }
            }
        }



        $discount = Discount::findOrFail($id);
        $discount->update($request->all());

        foreach ($discount->discount_categories as $key => $discount_categorie) {
            $discount_categorie->delete();
        }

        foreach ($discount->discount_products as $key => $discount_product) {
            $discount_product->delete();
        }

        foreach ($discount->discount_brands as $key => $discount_brand) {
            $discount_brand->delete();
        }

        foreach ($request->product_selected as $key => $product_selec) {
            DiscountProduct::create([
                "discount_id" => $discount->id,
                "product_id" => $product_selec["id"],
                "companie_id"=> $companie_id
            ]);
        }

        foreach ($request->categorie_selected as $key => $categorie_selec) {
            DiscountCategorie::create([
                "discount_id" => $discount->id,
                "categorie_id" => $categorie_selec["id"],
                "companie_id"=> $companie_id
            ]);
        }

        foreach ($request->brand_selected as $key => $brand_selec) {
            DiscountBrand::create([
                "discount_id" => $discount->id,
                "brand_id" => $brand_selec["id"],
                "companie_id"=> $companie_id
            ]);
        }



       // $discount_added = Discount::findOrFail( $discount->id);



        return response()->json(["message" => 200,
        "discount"=>    DiscountResource::make($discount),
        "discount id"=> $id
         ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = Discount::findOrFail($id);


        $discount->products()->delete();
        $discount->categories()->delete();
        $discount->brands()->delete();
        $discount->delete();
        // SI PERTENECE A UNA VENTA NO DEBE ELIMINARSE
        return response()->json(["message" => 200, "llego"=>"ok"]);
    }



    public function change_state(Request $request,$id)
    {
       //$state_id= $request->state_id;

        $discount=Discount::where("id",$id)->first();
        $discount->state_id =$discount->state->code==='Active'? 2:1;
        $discount->save();

        return response()->json(["message"=>200,
       // "discount" =>  BrandCollection::make($discount)
       "discount" => new DiscountResource($discount->fresh()),

        ]);

    }



}
