<?php

namespace App\Http\Resources\Ecommerce\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Ecommerce\Product\ProductHomeEcommerceResource;

class ProductHomeEcommerceCollection extends ResourceCollection
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
            ProductHomeEcommerceResource::collection($this->collection);


    }


}
