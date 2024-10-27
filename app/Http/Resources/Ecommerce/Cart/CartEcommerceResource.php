<?php

namespace App\Http\Resources\Ecommerce\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartEcommerceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
       // return parent::toArray($request);


       $discount_g=$this->resource->discount;

      // return $discount_g;


       return  [


        "id"=> $this->resource->id,
        "user"=>[
            "id"=>$this->resource->client->id,
            "name"=>$this->resource->client->name,
        ],

        "discount_g"=> ($discount_g)?
                [
                     "discount_type_id"=>$discount_g->discount_type_id,
                     "discount"=>$discount_g->discount,
                      "end_date"=>$discount_g->end_date,
                     // "end_date_countdown"=>Carbon::parse($discount_g->end_date)->format('M d Y H:i:s'),
                ]:null ,


        "product_variant"=>
        ($this->resource->product_variant )?
        [
          "id"=>$this->resource->product_variant->id,

          "product"=>[
                    "id"=>$this->resource->product_variant->product->id,
                    "title"=>$this->resource->product_variant->product->title,
                    "slug"=>$this->resource->product_variant->product->slug,

                // "price"=>$this->resource->product_variant->product->price,
                // "imagen"=> env("APP_URL")."/storage/".$this->resource->product_variant()->imagen,
                // "stock"=>$this->resource->product->stock,
                ],

               "inventory"=>[
                       "price"=> $this->resource->price_unit*$this->resource->currencie->exchange_rate,
               ],
               "online"=> $this->resource->product_variant->cover,
                  "sku" =>  $this->resource->product_variant->sku,
               "minimum_quantity" =>  $this->resource->product_variant->minimum_quantity,
                "image" => $this->resource->product_variant->product_imagen(), //$this->resource->product_variant->image,
             "dimension"=> $this->resource->product_variant_dimension?
                [
                    "id"=>$this->resource->product_size->id,
                    "name"=>$this->resource->product_size->name
                ]: NULL,

                    "attribute"=> $this->resource->product_variant_attribute?
                [
                    "id"=>$this->resource->product_color_size->id,
                    "name"=>$this->resource->product_color_size->product_color->name,
                    //"stock"=>$this->resource->product_color_size->stock
                ]: NULL,

        ]:null
        ,

       // "campaing"=> $this->resource->campaing,
        //"type_discount"=> $this->resource->discount_type,

        "quantity"=> $this->resource->quantity,
       // "stock"=> $this->resource->stock,
        // "code_coupon"=> $this->resource->code_coupon,
        // "code_discount"=> $this->resource->code_discount,
         "discount_id"=>$this->resource->discount_id,
        // "discount"=>$this->resource->discount,
        "discounted"=>$this->resource->discounted,
         "price_unit"=>  $this->resource->price_unit,
        // "price_net"=> $this->resource->price_net,
         "price_unit_currencie"=>  $this->resource->price_unit*$this->resource->currencie->exchange_rate,
        // "price_net_currencie"=> $this->resource->price_net*$this->resource->currencie->exchange_rate,
        // "saved"=> $this->resource->saved,
        "subtotal"=> $this->resource->subtotal,
        "total"=> $this->resource->total,
        "exchange_rate"=> $this->resource->currencie->exchange_rate,
        "currencie"=>$this->resource->currencie
       ];
    }
}
