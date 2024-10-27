<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\ProductVariantDimension;
use App\Models\Cart\Cart;
use App\Http\Resources\Cart\CartCollection;
use App\Models\Product\Product;
use App\Http\Resources\Cart\CartResource;
use App\Models\Coupon\Coupon;
use App\Models\Product\Categorie;
use App\Models\Discount\Discount;


class CartAdminController extends Controller
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


         $carts =Cart::where("user_id", auth('api')->user()->id)
         ->orderBy("id","desc")
        //->with('user','product_variant')
        ->with('discount')
          ->with('product_variant.product')
         ->with('product_variant.product_variant_dimension' )
         ->with('product_variant.product_variant_attribute' )
         ->get() ;

        //return   $carts ;

         //return $carts[0]->product_variant->product;


         // return $carts[0]->product_variant->product;


         return response()->json(["carts"=>CartCollection::make($carts)]);





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



        //PRIMER VALIDACION  de Producto Existente
        if($request->product_variant_dimension_id) //Si existe Seleccion Multiple
        {
            $validate_cart_shopt=Cart::
            where("product_variant_id", $request->product_variant_id)->
            where("product_variant_dimension_id",$request->product_variant_dimension_id)->
            where("product_variant_attribute_id",$request->product_variant_attribute_id)->
            where("user_id", auth('api')->user()->id)->first();
        }else{ //seleccion unitaria
             $validate_cart_shopt=Cart::where("product_variant_id", $request->product_variant_id)->where("user_id", auth('api')->user()->id)->first();;


        }

        if($validate_cart_shopt){
            return response()->json(
                [
                "message"=>403,
                "message_text"=>"EL PRODUCTO SELECCIONADO YA EXISTE"
                ]);
         }
          //TERMINA PROMER VALIDACION

        //Segunda Validacion de stock Disponible

     /*   if($request->product_variant_dimension_id){  //SI ES MULTIPLE SE VALIDA DESDE COLOR
          $dimension=    ProductVariantDimension::findOrFail($request->product_variant_dimension_id);
          if($dimension->stock<$request->quantity){
            return response()->json(
                [
                "message"=>403,
                "message_text"=>"EL PRODUCTO NO SE ENCUENTRA EN STOCK ACTUALMENTE"
                ]);
          }
        }else{        //SI ES UNITARIO
             $product= Product::findOrFail($request->product_id);
             if($product->stock<$request->quantity){
                return response()->json(
                    [
                    "message"=>403,
                    "message_text"=>"EL PRODUCTO NO SE ENCUENTRA EN STOCK ACTUALMENTE"
                    ]);
             }
        }
*/


        $discount=Discount::where("id",$request->discount_id)->get();

        $discount_value=0;
        if($discount&& count($discount)>0 )
        {

            // return response()->json(
            //     [
            //     "message"=>200, "sicount"=>$discount[0]
            //     ]
            //     );

            if($discount[0]->discount_type->code=="Percent")
            {
                $discount_value= $request->price_unit*$discount[0]->discount*$request->exchange_rate*.01;
            }else{
                $discount_value=  $discount[0]->discount*$request->exchange_rate;
            }
        }


        $request->request->add(["exchange_rate_currencie" =>  $request->exchange_rate]);
        $request->request->add(["discounted" =>  $discount_value*$request->quantity]);
        $request->request->add(["subtotal" =>  $request->price_unit*$request->exchange_rate *  $request->quantity]);
        $request->request->add(["total" =>  $request->subtotal - $discount_value*$request->quantity]);



/*


*/

         $cart_shop=Cart::create($request->all());



         return response()->json(
            [
            "message"=>200, "cart"=> CartResource::make($cart_shop)
            ]
        );

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



                //PRIMER VALIDACION  de Producto Existente
                if($request->product_variant_dimension_id) //Si existe Seleccion Multiple
                {
                    $validate_cart_shopt=Cart::
                    where("id","<>",$id)->
                    where("product_id", $request->product_id)->
                    where("product_variant_dimension_id",$request->product_variant_dimension_id)->
                    where("product_variant_attribute_id",$request->product_variant_attribute_id)->
                    where("user_id", auth('api')->user()->id)->first();


                }else{ //seleccion unitaria
                     $validate_cart_shopt=Cart::  where("id","<>",$id)->where("product_variant_id", $request->product_variant_id)->
                     where("user_id", auth('api')->user()->id)->first();


                }

                if($validate_cart_shopt){
                    return response()->json(
                        [
                        "message"=>403,
                        "message_text"=>"EL PRODUCTO SELECCIONADO YA EXISTE"
                        ]);
                 }
                  //TERMINA PRIMER VALIDACION

/*
        if($request->product_variant_dimension_id){  //SI ES MULTIPLE SE VALIDA DESDE COLOR
            $dimension=    ProductVariantDimension::findOrFail($request->product_variant_dimension_id);
            if($dimension->stock<$request->quantity){
              return response()->json(
                  [
                  "message"=>403,
                  "message_text"=>"EL PRODUCTO NO SE ENCUENTRA EN STOCK ACTUALMENTE"
                  ]);
            }
          }else{        //SI ES UNITARIO
               $product_variant= ProductVariant::findOrFail($request->product_variant_id);
               if($product_variant->stock<$request->quantity){
                  return response()->json(
                      [
                      "message"=>403,
                      "message_text"=>"EL PRODUCTO NO SE ENCUENTRA EN STOCK ACTUALMENTE"
                      ]);
               }
          }
*/



        $discount=Discount::where("id",$request->discount_id)->get();

        // return response()->json(
        //     [
        //     "message"=>200, "lego"=> $discount
        //     ]
        // );


        $discount_value=0;
        if($discount&& count($discount)>0 )
        {
            if($discount[0]->discount_type->code=="Percent")
            {
                $discount_value= $request->price_unit*$discount[0]->discount*$request->exchange_rate *.01;
            }else{
                $discount_value=  $discount[0]->discount*$request->exchange_rate;
            }
        }
        $request->request->add(["discounted" =>  $discount_value]);
        $request->request->add(["subtotal" =>  $request->price_unit*$request->exchange_rate *  $request->quantity]);
        $request->request->add(["total" =>  $request->subtotal - $discount_value*$request->quantity]);

          $cart_shop=Cart::findOrFail($id);
          $cart_shop->update($request->all());

           return response()->json(
              [
              "message"=>200, "cart"=> CartResource::make($cart_shop)
              ]
          );
    }


    public function all_update_currencie(Request $request)
    {
        foreach (($request->all())  as $key => $cart) {
            $cart['price_unit_currencie']= $cart['price_unit']??0 *  $cart['currencie']['exchange_rate'];
            $cart['price_net_currencie']= $cart['price_net']??0 *  $cart['currencie']['exchange_rate'];
            $cart['exchange_rate']= $cart['currencie']['exchange_rate'];


             $subtotal= ($cart['price_net']??0<=0)? $cart['price_unit'] *$cart['quantity']*  $cart['currencie']['exchange_rate']:
                                               $cart['price_net'] *$cart['quantity']*  $cart['currencie']['exchange_rate'];


                                               $discount=Discount::where("id",$cart['discount_id'])->get();

                                            //    return response()->json(
                                            //     [
                                            //     "message"=>200,
                                            //     "discount"=> $discount,
                                            //     "count discount"=>count($discount)
                                            //     ]
                                            // );

                                               $discount_value=0;
                                               if($discount&& count($discount)>0 )
                                               {
                                                   if($discount[0]->discount_type->code=="Percent")
                                                   {
                                                       $discount_value= $cart['price_unit']*$discount[0]->discount* $cart['exchange_rate'] *.01;
                                                   }else{
                                                       $discount_value=  $discount[0]->discount* $cart['exchange_rate'];
                                                   }
                                               }
           $cart['discounted']= $discount_value;
            $cart['exchange_rate']=$cart['currencie']['exchange_rate'];
            $cart['subtotal']= $subtotal;
            $cart['total']=$subtotal- $discount_value*$cart['quantity'];
            $cart['currencie_id']= $cart['currencie']['id'];
            // return response()->json(
            //     [
            //      $cart
            //     ]
            // );
            Cart::findOrFail($cart['id'])->update($cart);
        }

           return response()->json(
              [
              "message"=>200
              ]
          );
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function delete_all(){
        $user=auth("api")->user();
        $carts= Cart::where("user_id",$user->id)->get();




        foreach ($carts as $key => $cart) {
            $cart->delete();
        }

        return response()->json(
            [
            "message"=>200
            ]
        );


     }
    public function destroy($id)
    {
        $cart_shop=Cart::findOrFail($id);
          $cart_shop->delete();

           return response()->json(
              [
              "message"=>200
              ]
          );
    }


    public function apply_coupon($coupon)
    {
        $variables="";
        $coupon = Coupon::where("code",$coupon)->where("state_id",1)->first();
        if(!$coupon){
            return response()->json(["message" => 403, "message_text" => "EL CODIGO DEL CUPÓN INGRESADO NO EXISTE"]);
        }
        $user = auth("api")->user();
        $cartshops = Cart::where("user_id",$user->id)->orderBy("id","desc")->get();

        foreach ($cartshops as $key => $cart) {

            if($coupon->products){
                // [5,4]
                $products = explode(",",$coupon->products);

                if(in_array($cart->product_id,$products)){
                    $price_net=0;
                    $saved=0;
                    $subtotal = 0;
                    $total = 0;
                    //return $coupon->type_discount;

                    if($coupon->type_discount == 1){ //PORCENTAJE
                        $variables="Entro a porcentaje";
                        $saved= $cart->price_unit*($coupon->discount* 0.01);
                        $price_net= $cart->price_unit-$saved ;

                    }else{ //CANTIDAD
                        $saved=$coupon->discount;
                        $price_net= $cart->price_unit -  $saved;
                    }

                    $saved= $saved* $cart->quantity;
                    $subtotal= $cart->price_unit * $cart->quantity;
                    $total = $subtotal-  $saved;

                    $variables= "saved:" . $saved. "|"."price_net:". $price_net."|"."subtotal:". $subtotal."|". "total:". $total;

                    $cart->update(["subtotal" => $subtotal , "total" => $total, "price_net" => $price_net, "saved" => $saved,"type_discount" => $coupon->type_discount, "discount" => $coupon->discount ,"code_coupon" => $coupon->code]);
                }
            }
            if($coupon->categories){
                // [5,4]
                $categories = explode(",",$coupon->categories);
                $categories = explode(",",$coupon->categories);
                if(in_array($cart->product->categorie_id,$categories)){
                    $price_net=0;
                    $saved=0;
                    $subtotal = 0;
                    $total = 0;
                    if($coupon->type_discount == 1){ //PORCENTAJE
                        $saved= $cart->price_unit*($coupon->discount* 0.01);
                        $price_net= $cart->price_unit-$saved ;
                    }else{ //CANTIDAD
                        $saved=$coupon->discount;
                        $price_net= $cart->price_unit -  $saved;
                    }
                    $saved= $saved* $cart->quantity;
                    $subtotal= $cart->price_unit * $cart->quantity;
                    $total = $subtotal-  $saved;
                   $cart->update(["subtotal" => $subtotal ,"total" => $total,"price_net" => $price_net, "saved" => $saved,"type_discount" => $coupon->type_discount, "discount" => $coupon->discount ,"code_coupon" => $coupon->code]);
                }
            }
        }



        return response()->json(["message" => 200 ,"variables"=>$variables, "carts" => CartCollection::make($cartshops)]);
    }

}
