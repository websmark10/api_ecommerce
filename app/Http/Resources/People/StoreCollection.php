<?php

namespace App\Http\Resources\People;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Store\StoreResource;

class StoreCollection extends ResourceCollection
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

       return
         StoreResource::collection($this->collection)
        ;
    }
}
