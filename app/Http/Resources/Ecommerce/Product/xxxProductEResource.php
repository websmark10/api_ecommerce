<?php

namespace App\Http\Resources\Ecommerce\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductEResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        $discount_priority = null;
        $discount_debug="vacio";
        if($this->resource->discount_prod &&  $this->resource->discount_cat){
            $discount_priority =$this->resource->discount_prod;
            $discount_debug="IF";
        }else{
            if($this->resource->discount_prod && ! $this->resource->discount_cat){
                $discount_priority =$this->resource->discount_prod;
                $discount_debug="ELSE IF";
            }else{
                if(!$this->resource->discount_prod &&  $this->resource->discount_cat){
                    $discount_priority = $this->resource->discount_cat;
                    $discount_debug="ELSE ELSE";
                }
            }
        }


    //Logica de Descuento

     return [
        "idss"=>$this->resource->id,
        "title"=>$this->resource->title,
        "categorie_id"=>$this->resource->categorie_id,
       // "categorias"=>$this->resource->categorie,
      "categorie" =>   [
        "id" => $this->resource->categorie->id,
        "icono" => $this->resource->categorie->icono,
        "name" => $this->resource->categorie->name,
    ],

        "slug"=>$this->resource->slug,
        "sku"=>$this->resource->sku,

        "price"=>$this->resource->price,
        "price_usd"=>$this->resource->price_usd,
        "resumen"=>$this->resource->resumen,
        "description"=>$this->resource->description,

        "imagen"=> env("APP_URL")."/storage/" . $this->resource->imagen ,
        "stock"=>$this->resource-> stock,
        "checked_inventario"=>$this->resource->type_inventario,
        "reviews_count"=>$this->resource->reviews_count,
        "avg_rating" => round($this->resource->avg_rating),
        "discount_priority"=>$discount_priority,
        // "discount_debug"=>$discount_debug,
        // "discount_prod"=>$this->resource->discount_prod,
        // "discount_cat"=> $this->resource->discount_cat,
        "images"=>$this->resource->images-> map(function($img){
            return [
                "id" => $img->id,
                "file_name"=> $img->file_name,
                "imagen"=>env("APP_URL")."/storage/" . $img->imagen,
                "size"=> $img->size,
                "type"=> $img->type,
            ];
        }),
        "sizes"=>$this->resource->sizes->map(function($size){
            return [
                "id"=>$size->id,
                "name"=>$size->name,
                "total"=>$size->product_color_sizes->sum("stock"),
                "variaciones"=>$size->product_color_sizes->map(function($variacion){
                    return [
                        "id"=>$variacion->id,
                        "product_color_id"=> $variacion->product_color_id,
                        "product_color"=>$variacion->product_color,
                        "stock"=>$variacion->stock
                    ];
                }) //Sin el MAP solo se ven los ids
            ];
        })
    ];
}
}
