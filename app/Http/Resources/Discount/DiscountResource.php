<?php

namespace App\Http\Resources\Discount;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( $request)
    {


        return [
                "id" => $this->resource->id,
            "code" => $this->resource->code,
           "discount_type" => $this->resource->discount_type,
            "discount_method" => $this->resource->discount_method,
            "discount_apply" => $this->resource->discount_apply,
            "discount" => $this->resource->discount,
            "start_date" => Carbon::parse($this->resource->start_date)->format("Y-m-d"),
            "end_date" => Carbon::parse($this->resource->end_date)->format("Y-m-d"),

            "created_at" => $this->resource->created_at,//->format("Y-m-d h:i A"),//"6 AM 6PM"
            "campaign" => $this->resource->campaign,
            "state" => $this->resource->state,
            //"products" => $this->resource->products,
          "products_count"=> $this->resource->products_count,
          "products" => $this->resource->products->map(function($item) {
                return [
                    "id" => $item->pivot->product_id,
                   // "id" => $item->product->id,
                    "title" => $item->title,
                    "slug" => $item->slug,
                    //"imagen" => env("APP_URL")."storage/".$item->product->imagen,
                   // "id_aux" => $item->id,
                ];
            }),


            "categories_count"=> $this->resource->categories_count,
              "categories" => $this->resource->categories->map(function($item) {
                return [
                    "id" => $item->id,
                   // "id" => $item->categorie->id,
                    "name" => $item->name,
                   // "imagen" => env("APP_URL")."storage/".$item->categorie->imagen,
                   // "id_aux" => $item->id,
                ];
            }),
            "brands_count"=> $this->resource->brands_count,
            "brands" => $this->resource->brands->map(function($item) {
                return [
                    "id" => $item->id,
                    //"id" => $item->brand->id,
                    "name" => $item->name,
                    //"id_aux" => $item->id,
                ];
            }),
        ];
    }
}
