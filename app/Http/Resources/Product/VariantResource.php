<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {




      $folder_companie="";

       $sku=$this->resource->sku;

       $companie_path_url=  $this->product->companie_path_url();
       $companie_path_public= $this->product->companie_path_public() ;


            return [
            // "product_variant_attribute_id"=>  $var->product_variant_attribute_id,
            // "product_variant_dimension_id"=>   $var->product_variant_dimension_id,
                        "id"=>$this->id,

                        "online"=>  $this->online,
                        "cover"=>  $this->cover,
                        "minimum_quantity"=>  $this->minimum_quantity,
                        "sku"=>  $this->sku,
                        "dimension"=>
                          ( $this->product_variant_dimension)?
                           [

                            "id" => $this->product_variant_dimension->id,
                            "code" => $this->product_variant_dimension->code,
                            "name" => $this->product_variant_dimension->name,
                            ]:null
                            ,
                        "attribute"=>
                          (  $this->product_variant_attribute)?
                            [

                            "id" =>   $this->product_variant_attribute->id,
                            "code" =>   $this->product_variant_attribute->code,
                            "name" =>   $this->product_variant_attribute->name,
                            ]:null
                            ,

                   // "image"=>   $this->image,
                    "product_variant_state"=>[

                        "id" => $this->product_variant_state->id,
                        "code" => $this->product_variant_state->code,
                        "name" => $this->product_variant_state->name,

                        ],

                        "imagen"=>$this-> product_imagen(),
                         "images"=>    $this->product_variant_images->map( function($img) use($companie_path_url, $companie_path_public){



                            if($this->product->inventory_type->code=='INDIVIDUAL')
                            return    (  file_exists(  $companie_path_public  .'\\products\\'.   $img->product_id. "/images/"  .$img->name  ))?
                                  [
                                             "url"=>  $companie_path_url."/products/".   $img->product_id. "/images/" .  $img->name ,
                                            "name"=>    $img->name ,
                                            "size"=>  (string)filesize(  $companie_path_public ."\\products\\".   $img->product_id. "/images/" .$img->name )
                                        ] :
                                        [
                                        "url"=> $companie_path_url ."/products/" . "noimage.png",
                                        "name"=>  $img->name ,
                                        "size"=> (string) filesize( $companie_path_public ."\\products\\" . "noimage.png")
                                        ] ;

                            else if($this->product->inventory_type->code=='MULTIPLE')


                            return    (  file_exists(  $companie_path_public  .'\\products\\'.   $img->product_id. "\\variants\\". $img->product_variant_id."\\images\\"  .$img->name  ))?
                            [
                                       "url"=>  $companie_path_url."/products/".   $img->product_id. "/variants/". $img->product_variant_id."/images/"  .$img->name ,
                                      "name"=>    $img->name ,
                                      "size"=>  (string)filesize(  $companie_path_public .'\\products\\'.   $img->product_id. "\\variants\\". $img->product_variant_id."\\images\\"  .$img->name  )
                                  ] :
                                  [
                                  "url"=> $companie_path_url ."/products/" . "noimage.png",
                                  "name"=>  $img->id.".jpg" ,
                                  "size"=> (string) filesize( $companie_path_public ."\\products\\" . "noimage.png")
                                  ] ;
                              })



                   , "inventory"=> //$this->inventories(),
                        ($this->inventory())?
                                [
                                //$this->inventory()->first()
                                    "batch"=>$this->inventory()->batch?->file_name,
                                    "price"=>$this->inventory()->price,
                                    "cost"=>$this->inventory()->cost,
                                    "stock"=>$this->inventory()->stock,
                                    "available"=>$this->inventory()->available,
                                    "manufactured_date"=>$this->inventory()->manufactured_date,
                                    "expiry_date"=>$this->inventory()->expiry_date,
                                ]:null ,

                                "discount_variant_product"=> $this->getDiscountVariantProduct(),



                        ];



    }

 public   function human_filesize($size, $precision = 1, $show = "")
{
    $b = $size;
    $kb = round($size / 1024, $precision);
    $mb = round($kb / 1024, $precision);
    $gb = round($mb / 1024, $precision);

    if($kb == 0 || $show == "B") {
        return $b . " bytes";
    } else if($mb == 0 || $show == "KB") {
        return $kb . "KB";
    } else if($gb == 0 || $show == "MB") {
        return $mb . "MB";
    } else {
        return $gb . "GB";
    }
}


}
