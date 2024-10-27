<?php

namespace App\Http\Resources\Ecommerce\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductEcommerceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray( $request)
    {
        // return [
        //      ProductEcommerceResource::collection($this->collection),
        // ];

        return
            ProductEcommerceResource::collection($this->collection);


    }


}
