<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\VerifiedMail;
use App\Mail\Auth\ForgotPasswordMail;
use Carbon\Carbon;
use Illuminate\Validation\Rule;


class JWTController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','loginAdmin','loginEcommerce', 'register','test','testa','verified_auth','verified_email','verified_code','new_password']]);

    }

     public function test(){
        return "pruebatest";
     }
    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'surname' => 'required|string|min:2|max:100',
            'phone' => 'required',
            'companie_id' => 'required|integer',
           // 'email' => 'required|string|email|max:100|unique:users',
           'email' => [
                'required',
                //'unique:users,email,companie_id',
                //Rule::unique('users', 'email')->using(function ($q) { $q->where('companie_id',  $request->companie_id); }),
                Rule::unique('users')->where(fn ($query) => $query->where('companie_id', $request->companie_id)),
            ],

            //'companie_id' => 'required|string',
          //  'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:8|',
            'confirmPassword' => 'required|string|min:8',
        ]);

        if($validator->fails()) {
           // return response()->json(['error' => 'Unauthorized', $validator->errors()], 400);
           return response()->json(['error' => 'Unauthorized', 'fields'=> $validator->errors()], 400);

        }

        $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'companie_id' => $request->companie_id,
                'user_type_id' => $request->user_type_id,
                'state_id' => 1,
                'password' => $request->password,
                'unique_id'=>uniqid(),
               // 'password' => Hash::make($request->password)
              // 'password' => bcrypt($request->password)

            ]);

              Mail::to(request()->email)->send(new VerifiedMail($user));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

 
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);





        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        if (!$token = auth()->attempt(["email"=>$request->email, "password"=>$request->password,"companie_id"=>$request->companie_id, "user_type_id"=>$request->user_type_id,   "state_id"=>1])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return $this->respondWithToken($token);
    }


    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get user profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user=auth()->user();

        return response()->json([

            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 600,
            //'user'=>auth()->user()->with(['Role'])->get(),
            'user'=>[
                'id'=>$user->id,
                'name'=>$user->name,
                'surname'=>$user->surname,
                'email'=>$user->email,
                'role'=>$user->role,
                'avatar'=>$user->companie->companie_path_url()."/users/" . $user->avatar,
                'companie'=>
                     [
                     'id'=>$user->id,
                     'code'=>$user->companie->code,
                     'name'=>$user->companie->name,
                     'path'=>$user->companie->companie_path_url(),
                     'slogan'=>$user->companie->slogan,
                     'folder'=> $user->companie_folder(),
                     'logo'=>$user->companie->companie_path_url()."/logos/".$user->logo
                    ]
                ,
                'currencie'=> $user->companie->currencie()
            //    'stores'=>$user->stores-> map(function($store){
            //             return [
            //              'id'=>$store->id,
            //              'name'=>$store->name,
            //             ];
            //         })

            ]
        ]);
    }


    public function verified_email(Request $request){
        $user = User::where("email",$request->email)->where("companie_id",$request->companie_id)->first();
        if($user){
            $user->update(["code_verified" => uniqid()]);
            Mail::to($request->email)->send(new ForgotPasswordMail($user));
            return response()->json(["message" => 200]);
        }else{
            return response()->json(["message" => 403]);
        }
    }
    public function verified_code(Request $request){
        $user = User::where("code_verified",$request->code)->first();
        if($user){
           // $user->update([ "email_verified_at"=> Carbon::now()]);

            return response()->json(["message" => 200]);
        }else{
            return response()->json(["message" => 403]);
        }
    }
    public function new_password(Request $request){
        $user = User::where("code_verified",$request->code)->first();
        $user->update(["password" =>$request->new_password,"code_verified" => null]);
        return response()->json(["message" => 200]);
    }

    public function verified_auth(Request $request){
        $user = User::where("unique_id", $request->code_user)->first();

        if($user){
            $user->update(["email_verified_at" => now()]);
            return response()->json(["message" => 200]);
        }

        return response()->json(["message" => 403]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

}
