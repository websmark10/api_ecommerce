<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       //  return parent::toArray($request);
        return [
            "id"=>$this->resource->id,
            "code"=>$this->resource->code,
            "name"=>$this->resource->name,
            "imagen"=>
                        ( $this->resource->imagen && file_exists(public_path('storage\\brands\\'.$this->resource->imagen))) ?
                                [
                                    "url"=> env("APP_URL")."/storage/brands/" . $this->resource->imagen ,
                                    "name"=>   $this->resource->imagen ,
                                    "size"=>  (string)filesize(public_path("storage\\brands\\" . $this->resource->imagen ))
                                ]: (
                                    (! file_exists(public_path('storage\\brands\\'.$this->resource->imagen)))?
                                    [
                                        "url"=> env("APP_URL")."/storage/brands/" . "noimage.png",
                                        "name"=>   $this->resource->imagen,
                                         "size"=> filesize( public_path("storage\\brands\\" . "noimage.png" ))
                                       // "size"=>  (string)filesize(public_path("storage\\brands\\" . $this->resource->imagen ))
                                    ]

                                    : //null
                                    [
                                        "url"=> env("APP_URL")."/storage/brands/" . "noimage.png",
                                        "name"=>  "noimage.png",
                                         "size"=> filesize( public_path("storage\\brands\\" . "noimage.png" ))
                                       // "size"=>  (string)filesize(public_path("storage\\brands\\" . $this->resource->imagen ))
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
