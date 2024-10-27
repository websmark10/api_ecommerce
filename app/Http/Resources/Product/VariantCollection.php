<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VariantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
    //    return [
    //      //"data"=>ProductCResource::collection($this->collection)
    //     ProductCResource::collection($this->collection),

    //    ];

     return VariantResource::collection($this->collection);


    }
}
