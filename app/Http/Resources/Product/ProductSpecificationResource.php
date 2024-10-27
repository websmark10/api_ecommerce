<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProductSpecificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [

          // "inventory_type_code"=>,

            "id"=>$this->resource->id,
            "value"=>$this->resource->value,
            "state_id"=>$this->resource->state_id,
            "cat_attribute" =>
               [
                "id"=> $this->resource->cat_attribute->id,
               "name" => $this->resource->cat_attribute->name,
               "type" =>
                    [
                        "id"=> $this->resource->cat_attribute->cat_attribute_type->id,
                    "code" =>  $this->resource->cat_attribute->cat_attribute_type->code
                    ],
                ],
           "attribute"=>
               $this->resource->attribute?
                [
                    "id" =>$this->resource->attribute->id,
                    "name" =>$this->resource->attribute->name,
                   "ref" =>$this->resource->attribute->ref
                ] :[]


                ];

    }

 public   function human_filesize($size, $precision = 1, $show = "")
{
    $b = $size;
    $kb = round($size / 1024, $precision);
    $mb = round($kb / 1024, $precision);
    $gb = round($mb / 1024, $precision);

    if($kb == 0 || $show == "B") {
        return $b . " bytes";
    } else if($mb == 0 || $show == "KB") {
        return $kb . "KB";
    } else if($gb == 0 || $show == "MB") {
        return $mb . "MB";
    } else {
        return $gb . "GB";
    }
}


}
