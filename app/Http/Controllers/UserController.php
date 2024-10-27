<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['all','test','testa']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        return "Test my register admin";
    }




    public function index(Request $request)
    {
        $state = $request->get("state_id");//''
        $search = $request->get("search");
        $users = User::filterAdvance($state,$search)->where("role_id",2)->orderBy("id","desc")->paginate(20);

        return response()->json([
            "total" => $users->total(),
            "users" => $users,
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
         $user= User::where("email", $request->email)->first();
         if($user){
            return response()->json(["message"=>400]);
         }else{
            $user=User::create($request->all());  //Asignacion Masiva
            return response()->json(["message"=>200,"user"=>$user]);
         }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
             $user= User::where("email", $request->email)->where("id", "<>",$id)->first();

             if($user){
                return response()->json(["message"=>400]);
             }else{
                $user=User::findOrFail($id);
                $user->update($request->all());
                return response()->json(["message"=>200,"user"=>$user]);
             }
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $user= User::findOrFail($id);
         $user->delete();
    }
}
