<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

       $user=auth()->user();

       $companie_path_url=  $user->companie_path_url();
       $companie_path_public= $user->companie_path_public() ;


        return [
            "id"=>$this->resource->id,
            "code"=>$this->resource->code,
            "name"=>$this->resource->name,
            "imagen"=>
        ( !empty($this->resource->imagen) &&  file_exists(  $companie_path_public  .'\\categories\\'.  $this->resource->imagen))?
         [
              "url"=>  $companie_path_url."/categories/".   $this->resource->imagen ,
             "name"=>    $this->resource->imagen ,
             "size"=>  (string)filesize(  $companie_path_public ."\\categories\\".  $this->resource->imagen )
         ] :
         [
         "url"=> $companie_path_url ."/categories/" . "noimage.png",
         "name"=>  $this->resource->imagen ,
         "size"=> (string) filesize( $companie_path_public ."\\categories\\" . "noimage.png")
         ],

            "description"=>$this->resource->description??'',
            "stamps"=> [
                "created_at"=>$this->resource->created_at??'',
                "updated_at"=>$this->resource->updated_at??'',
                "deleted_at"=>$this->resource->deleted_at??'',
                "created_by"=>$this->resource->creator->name??'',
                "updated_by"=>$this->resource->editor->name??'',
                "deleted_by"=>$this->resource->destroyer->name??'',
            ],
            "supercategorie"=>[
                "id"=> $this->resource->supercategorie->id,
                "code"=> $this->resource->supercategorie->code,
                "name"=> $this->resource->supercategorie->name
            ],
            //"state_id"=>$this->resource->state_id,
            "state"=> [
                            "id"=> $this->resource->state->id,
                            "code"=> $this->resource->state->code
                     ]

        ];
    }
}
