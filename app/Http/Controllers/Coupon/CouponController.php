<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon\Coupon;
use App\Models\Product\Product;
use App\Models\Product\Categorie;
use App\Http\Resources\Coupon\CouponCollection;
use App\Models\Discount\Campaign;
use App\Models\Discount\CampaignType;
use App\Models\Discount\DiscountMethod;
use App\Models\Discount\DiscountType;
use App\Models\Discount\DiscountApply;
use App\Models\Discount\DiscountCountable;
use App\Models\Product\State;
use App\Models\Coupon\CouponProduct;
use App\Models\Coupon\CouponCategorie;
use App\Models\Coupon\CouponBrand;
use App\Http\Resources\Coupon\CouponResource;

class CouponController extends Controller
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

        $coupons = Coupon::filter($companie_id,$state_id,$start_date,$end_date,$search)->orderBy("id","desc")->paginate($pageSize);


        return response()->json([
            "totalData" => $coupons->total(),
           // "coupons"=> $coupons,
             "data" => CouponCollection::make($coupons->setHidden([
                'created_at', 'updated_at'  , 'deleted_at'
            ])),
            //"coupons" => DiscountResource::make($coupons),
        ]);
    }


    public function info(){



        $user=auth()->user();



       $companie_id= $user->companie_id;

       $campaigns =Campaign::Where("companie_id", $companie_id )->Where("state_id",1)->get();

       $campaign_types =CampaignType:: Where("state_id",1)->get();

      $discount_countables=DiscountCountable:: Where("state_id",1)->get();

       $discount_types=DiscountType::Where("state_id",1)->get();

       $discount_applys=DiscountApply::Where("state_id",1)->get();

       $states=State::get();


        return response()->json([
           "campaigns"=>$campaigns,
           "discount_countables"=>$discount_countables,
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
        $user=auth()->user();
        $companie_id= $user->companie->id;
        $request->request->add(["companie_id" =>$companie_id]);
        $IS_VALID = Coupon::where("code", $request->code)->first();
        if($IS_VALID){
            return response()->json(["message" => 403, "message_text" => "EL CODIGO DEL CUPON YA EXISTE"]);
        }

        if($request->discount_apply_id == 1){//VALIDACION A NIVEL DE PRODUCTOS
            $products = [];
            foreach ($request->products_selected as $key => $product) {
                array_push($products,$product["id"]);
            }
            // [2,3,4] => 2,3,4
            $request->request->add(["products" => implode(",",$products)]);
        }
        if($request->discount_apply_id == 2){//VALIDACION A NIVEL DE CATEGORIA
            $categories = [];
            foreach ($request->categories_selected as $key => $categorie) {
                array_push($categories,$categorie["id"]);
            }
            $request->request->add(["categories" => implode(",",$categories)]);
        }

        if($request->discount_apply_id == 3){//VALIDACION A NIVEL DE MARCAS
            $brands = [];
            foreach ($request->brands_selected as $key => $brand) {
                array_push($brands,$brand["id"]);
            }
            $request->request->add(["brands" => implode(",",$brands)]);
        }

       $coupon= Coupon::create($request->all());

       foreach ($request->products_selected as $key => $product_selec) {
        CouponProduct::create([
            "coupon_id" => $coupon->id,
            "product_id" => $product_selec["id"],
            "companie_id" => $companie_id
        ]);
    }

    foreach ($request->categories_selected as $key => $categorie_selec) {
        CouponCategorie::create([
            "coupon_id" => $coupon->id,
            "categorie_id" => $categorie_selec["id"],
            "companie_id"=>$companie_id
        ]);
    }

    foreach ($request->brands_selected as $key => $brand_selec) {
        CouponBrand::create([
            "coupon_id" => $coupon->id,
            "brand_id" => $brand_selec["id"],
            "companie_id"=>$companie_id
        ]);
    }



        $coupon_added = Coupon::findOrFail( $coupon->id);





        return response()->json(["message" => 200,
        "coupon"=> CouponResource::make($coupon_added),
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
        $coupon = Coupon::findOrFail($id);

        return response()->json(["message" => 200 , "coupon" => CouponResource::make($coupon)]);
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
        $IS_VALID = Coupon::where("id","<>",$id)->where("code", $request->code)->first();
        if($IS_VALID){
            return response()->json(["message" => 403, "message_text" => "EL CODIGO DEL CUPON YA EXISTE"]);
        }

        $user=auth()->user();
        $companie_id= $user->companie_id;


       $coupon=Coupon::findOrFail($id);

       $coupon->update($request->all());


       foreach ($coupon->products as $key => $product) {
        $product->delete();
       }
       foreach ($coupon->categories as $key => $categorie) {
        $categorie->delete();
       }
       foreach ($coupon->brands as $key => $brand) {
        $brand->delete();
       }



        if($request->discount_apply_id == 1){
            foreach ($request->products_selected as $key => $product) {
                CouponProduct::create([
                    "coupon_id" => $request->id,
                    "product_id" => $product["id"],
                    "companie_id"=> $companie_id
                ]);
            }
        }
        if($request->discount_apply_id == 2){

            foreach ($request->categories_selected as $key => $categorie) {

                CouponCategorie::create([
                    "coupon_id" => $request->id,
                    "categorie_id" => $categorie["id"],
                    "companie_id"=> $companie_id
                ]);
            }
        }

        if($request->discount_apply_id == 3){

            foreach ($request->brands_selected as $key => $brand) {
                CouponBrand::create([
                    "coupon_id" => $request->id,
                    "brand_id" => $brand["id"],
                    "companie_id"=> $companie_id
                ]);
            }
        }




        return response()->json(["message" => 200,"coupon"=>    CouponResource::make($coupon->fresh())]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon=Coupon::findOrFail($id);
        //$coupon->state=0;
        $coupon->delete();

        return response()->json(["message" => 200]);
    }


    public function change_state(Request $request,$id)
    {
       //$state_id= $request->state_id;

        $coupon=Coupon::where("id",$id)->first();
        $coupon->state_id =$coupon->state->code==='Active'? 2:1;
        $coupon->save();

        return response()->json(["message"=>200,
       // "coupon" =>  BrandCollection::make($coupon)
       "coupon" => new CouponResource($coupon->fresh()),

        ]);

    }

}
