<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SupercategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $folderCompanie= $request->folder_companie ;


        return [

            "id"=>$this->resource->id,
            "code"=>$this->resource->code,
            "name"=>$this->resource->name,
            "imagen"=> ( $this->resource->imagen && file_exists(public_path('storage//companies//'.$folderCompanie.'//supercategories//'.$this->resource->imagen))) ?
                                [
                                    "url"=> env("APP_URL")."/storage/companies/".$folderCompanie."/supercategories/" . $this->resource->imagen ,
                                    "name"=>   $this->resource->imagen ,
                                    "size"=>  (string)filesize(public_path("storage//companies//".$folderCompanie."//supercategories//" . $this->resource->imagen ))
                                ]: (
                                    (! file_exists(public_path('storage//companies//'.$folderCompanie.'//supercategories//'.$this->resource->imagen)))?
                                    [
                                        "url"=> env("APP_URL")."/storage/companies/".$folderCompanie."/supercategories/" . "noimage.png",
                                        "name"=>   $this->resource->imagen,
                                         "size"=> filesize( public_path("storage//companies//".$folderCompanie."//supercategories//" . "noimage.png" ))

                                    ]
                                    :
                                    [
                                        "url"=> env("APP_URL")."/storage/companies/".$folderCompanie."/supercategories/" . "noimage.png",
                                        "name"=>  "noimage.png",
                                         "size"=> filesize( public_path("storage//companies//".$folderCompanie."//supercategories//" . "noimage.png" ))

                                    ]
                                )
                                ,
            "description"=>$this->resource->description??'',
            "stamps"=> [
                "created_at"=>$this->resource->created_at??'',
                "updated_at"=>$this->resource->updated_at??'',
                "deleted_at"=>$this->resource->deleted_at??'',
                "created_by"=>$this->resource->creator->name??'',
                "updated_by"=>$this->resource->editor->name??'',
                "deleted_by"=>$this->resource->destroyer->name??'',
            ],
            "state_id"=>$this->resource->state_id,
            "state"=> [
                            "id"=> $this->resource->state->id,
                            "code"=> $this->resource->state->code
                     ]

        ];
    }
}
