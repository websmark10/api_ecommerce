<?php

namespace App\Http\Resources\Discount;

//use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DiscountCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return      DiscountResource::collection($this->collection) ;

        // return [
        //     "data" =>"Hola"
        //    // "data" => DiscountResource::collection($this->collection),
        // ];
     //   return DiscountResource::collection($this->collection);
    }

}
