<?php

namespace App\Http\Resources\Ecommerce\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Ecommerce\Cart\CartEcommerceResource;

class CartEcommerceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
 /*   public function toArray(Request $request): array
    {
        return [
            "data" => CartEcommerceResource::collection($this->collection),
        ];
    }*/

    public function toArray($request)
    {
       // return parent::toArray($request);

       return
         //CartShopResource::collection($this->collection)
         CartEcommerceResource::collection($this->collection)

       ;
    }
}
