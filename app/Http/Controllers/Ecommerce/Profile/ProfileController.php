<?php

namespace App\Http\Controllers\Ecommerce\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client\AddressUser;
use Carbon\Carbon;
use App\Models\Sale\Sale;
use App\Http\Resources\Ecommerce\Sale\SaleCollection;
use auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Sale\SaleDetail;
use App\Models\Sale\WishList\Wishlist;

class ProfileController extends Controller
{
    //


    public function index(){
        $user= auth('api')->user();
        $address=AddressUser::where("user_id", $user->id)->orderBy("id","desc")->get();
        $orders= Sale::where("user_id", $user->id)->orderBy("id","desc")->get();
        $wishlists = Wishlist::where("user_id",auth('api')->user()->id)->orderBy("id","desc")->get();
        $sales_details=SaleDetail::whereHas("sale",function($q) use($user){
            $q->where("user_id",$user->id);
        })->with(["review","product","sale"])->orderBy("sale_id","desc")->get();;

        return response()->json([
            "user"=>[
                "id"=>$user->id,
                "name"=> $user->name,
                "surname"=> $user->surname,
                "email"=> $user->email,
                "birthday"=> $user->birthday? Carbon::parse($user->birthday)->format('Y-m-d'):NULL,
                "gender"=> $user->gender,
                "avatar" =>  $user->avatar? env("APP_URL")."/storage/". $user->avatar:null,
                "phone" => $user->phone,
            ],
            "address"=> $address->map(function ($addres){
                return [
                    "id"=> $addres->id,
                     "full_name"=> $addres->full_name,
                     "full_surname"=> $addres->full_surname,
                     "company_name"=> $addres->company_name,
                     "country_region"=> $addres->country_region,
                     "street_number"=> $addres->street_number,
                     "city"=> $addres->city,
                     "zip_code"=> $addres->zip_code,
                     "phone"=> $addres->phone,
                     "email"=> $addres->email
                ];
            }),
            "orders"=> SaleCollection::make($orders),
            "reviews"=> $sales_details->map(function($sale_detail){
                return [
                    "id"=>$sale_detail->id,
                    "n_transaccion"=>$sale_detail->sale->n_transaccion,
                    "created_at"=>$sale_detail->created_at->format("Y-m-d"),
                    "product"=>[
                        "id"=>$sale_detail->product_id,
                        "title"=>$sale_detail->product->title,
                        "imagen"=>env("APP_URL")."/storage/". $sale_detail->product->imagen,
                    ],
                    "total"=>$sale_detail->total,
                    "currency_payment"=>$sale_detail->sale->currency_payment,
                    "review" => $sale_detail->review,
                ];
            }),
            "wishlists" => $wishlists->map(function($wishlist){
                return [
                    "id" => $wishlist->id,
                    "user" => [
                        "id" => $wishlist->client->id,
                        "name" =>$wishlist->client->name,
                    ],
                    "product_size_id" => $wishlist->product_size_id,
                    "product_color_size_id" => $wishlist->product_color_size_id,
                    "product" => [
                        "id" =>  $wishlist->product->id,
                        "title" => $wishlist->product->title,
                        "slug" => $wishlist->product->slug,
                        "price" => $wishlist->product->price,
                        "price_usd" => $wishlist->product->price_usd,
                        "imagen" =>  env("APP_URL")."/storage/".$wishlist->product->imagen,
                    ],
                ];
            }),
        ]);
    }

    public function profile_update(Request $request){

        $user=auth()->user();

        if($request->current_password){ //Para revisar si si es la contraseña actual;
            if(!Hash::check($request->current_password,  $user->password))
            {
                return response()->json(["message"=>403, "message_text"=>"El password actual no es el correcto."]);
            }

            $validator = $request->validate([
                'password' => 'required|string|min:6',
            ]);

            // if ($validator->fails()) {
            //   //  return response()->json($validator, 422);
            //     return response()->json(["message"=>422, "message_text"=>$validator->errors()->all()]);
            // }
        }
        if($request->hasFile("imagen")){
            if($user->avatar){
               Storage::delete($user->avatar);
            }
            $path=Storage::putFile("users", $request->file("imagen"));
            $request->request->add(["avatar"=>$path]);
        }

        $users_model= User::find($user->id);
        $users_model->update($request->all());

        return response()->json(["message"=>200, "user"=> [
            "id"=>$users_model->id,
            "name"=> $users_model->name,
            "surname"=> $users_model->surname,
            "email"=> $users_model->email,
            "birthday"=> $users_model->birthday? Carbon::parse($users_model->birthday)->format('Y-m-d'):NULL,
            "gender"=> $users_model->gender,
            "avatar" =>  $users_model->avatar? env("APP_URL")."/storage/". $users_model->avatar:null,
            "phone" => $users_model->phone,
        ],
    ]);


    }
}
