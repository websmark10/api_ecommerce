<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductDetailsCollection extends ResourceCollection
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

     return ProductDetailsResource::collection($this->collection);


    }
}
