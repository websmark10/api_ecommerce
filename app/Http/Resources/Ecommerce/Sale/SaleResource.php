<?php

namespace App\Http\Resources\Ecommerce\Sale;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            "id"=>$this->resource->id,
            "user"=>[
                "id"=>$this->resource->user->id,
                "full_name"=>$this->resource->user->name. '  ' .$this->resource->user->surname,
            ],
            "method_payment"=>$this->resource->method_payment,
            "currency_total"=>$this->resource->currency_total,
            "currency_payment"=>$this->resource->currency_payment,
            "saved"=>$this->resource->saved,
            "subtotal"=>$this->resource->subtotal,
            "total"=>$this->resource->total,
            "price_dolar"=>$this->resource->price_dolar,
            "n_transaccion"=>$this->resource->n_transaccion,
            "created_at"=>$this->resource->created_at->format("d/m/Y"),
            "items"=>$this->resource->sale_details->map(function($detail){
                return [
                    "id"=>$detail->id,
                    "title"=>$detail->product->title,
                    "type_discount"=>$detail->type_discount,
                    "discount"=>$detail->discount,
                    "quantity"=>$detail->quantity,
                    "imagen"=>env("APP_URL")."/storage/" .$detail->product->imagen,
                    "product_size_id"=>$detail->product_size?
                        [
                            "id"=>$detail->product_size->id,
                            "name"=>$detail->product_size->name
                        ]:NULL,
                    "product_color_size_id"=>$detail->product_color_size?
                    [
                        "id"=>$detail->product_color_size->id,
                        "name"=>$detail->product_color_size->name
                    ]:NULL,
                    "code_coupon"=>$detail->code_coupon,
                    "code_discount"=>$detail->code_discount,
                    "price_unit"=>$detail->price_unit,
                    "price_net"=>$detail->price_net,
                    "saved"=>$detail->saved,
                    "subtotal"=>$detail->subtotal,
                    "total"=>$detail->total,
                    ];
            }),
        ];
    }
}
