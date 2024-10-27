<?php

namespace App\Http\Controllers\Slider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['test','testa']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



        // return  $folder_companie;
        $search = $request->search;

        $sliders = Slider::where("title","like","%".$search."%")->orderBy("id","desc")->paginate(25);

        return response()->json([
            "totalData" => $sliders->total(),
            "data" => $sliders->map(function($slider)  {
                return [
                    "id" => $slider->id ,
                    "title" => $slider->title ,
                    "subtitle" => $slider->subtitle ,
                    "label" => $slider->label ,
                    "link" => $slider->link ,
                    "state" => $slider->state ,
                    "color" => $slider->color ,
                     "image" =>$slider->imagen,
                    "stamps"=> [
                        "created_at"=>$this->resource->created_at??'',
                        "updated_at"=>$this->resource->updated_at??'',
                        "deleted_at"=>$this->resource->deleted_at??'',
                        "created_by"=>$this->resource->creator->name??'',
                        "updated_by"=>$this->resource->editor->name??'',
                        "deleted_by"=>$this->resource->destroyer->name??''
                    ],
                ];
            }),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user=auth()->user();


        $request->request->add(["companie_id" =>  $user->companie->id]);

//return $request->all();

       // $req['code_brand'])->value('id')


       if($request->hasFile("imagen_file"))
        {
            $nameFile= $request->file("imagen_file")->getClientOriginalName();
            $path = Storage::putFileAs("companies/". $user->companie->folder_companie."/sliders",$request->file("imagen_file"),$nameFile);
            $request->request->add(["imagen" =>$nameFile]);
            $slider = Slider::create($request->all());
        }

          return response()->json(["message" => 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Slider::findOrFail($id);


        $user=auth()->user();
        $folder_companie=$user->companie->folder_companie;
        //return $user->companie->folder_companie;

        return response()->json(["message"=>200,
            "slider" => [
                "id" => $slider->id ,
                "title" => $slider->title ,
                "subtitle" => $slider->subtitle ,
                "label" => $slider->label ,
                "link" => $slider->link ,
                "state" => $slider->state ,
                "color" => $slider->color ,
                "image" =>
                [
                    "url"=>  env("APP_URL")."/storage/companies/". $folder_companie."/sliders/".$slider->imagen,
                    "name"=>  $slider->imagen,
                    "size"=>  (string)filesize(public_path("storage\\companies\\" . $folder_companie."\\sliders\\". $slider->imagen ))
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);
        $user=auth()->user();
        $folder_companie=$user->companie->folder_companie;
        if($request->hasFile("imagen_file"))
        {
            $nameFile= $request->file("imagen_file")->getClientOriginalName();
            $path = Storage::putFileAs("companies/".  $folder_companie."/sliders",$request->file("imagen_file"),$nameFile);
            $request->request->add(["imagen" =>$nameFile]);
            $request->request->add(["companie_id" =>  $user->companie->id]);

            $slider = Slider::create($request->all());
        }


        $slider->update($request->all());
        return response()->json(["message" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        return response()->json(["message" => 200, "data"=> $slider]);
    }

}
