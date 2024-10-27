<?php

namespace App\Http\Resources\Ecommerce\Product\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Ecommerce\Product\Home\DeptoProductHomeEcommerceResource;

class DeptoProductHomeEcommerceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray( $request)
    {
        return
        DeptoProductHomeEcommerceResource::collection($this->collection);

    }


}
