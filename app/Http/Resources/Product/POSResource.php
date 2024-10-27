<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class POSResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        $prod= $this->resource;

        $companie_path_url= $prod->companie->companie_path_url();
        $companie_path_public=$prod->companie->companie_path_public() ;

       //  return parent::toArray($request);


    // return    $prod->map( function($prod) use($companie_path_url, $companie_path_public){



        $discount_g = null;

        $discount_collect = collect([]);
       // $discount_collect = (new Discount)->newCollection();

       foreach ( $prod->discount_products  as $key => $item) {
        $discount_collect->push($item->discount);
        }

        // $discount_categories =$prod->discount_categories;
        // if($discount_categories){
        //     $discount_collect->push($discount_categories);
        // }
        // $discount_brands = $prod->discount_brands;
        // if($discount_brands){
        //     $discount_collect->push($discount_brands);
        // }

        if($discount_collect->count() > 0){
            $discount_g = $discount_collect->sortByDesc("discount")->values()->all()[0];
        }





        $inventory_type_code=$prod->inventory_type->code;
         $var=$prod->variant_cover;


        return [

       "id"=>$prod->id,
        "title"=>$prod->title,
        "discount_g"=> ($discount_g)?
        [
            "id"=>$discount_g->id,
             "discount_type_id"=>$discount_g->discount_type_id,
             "discount"=>$discount_g->discount,
              "end_date"=>$discount_g->end_date,
             // "end_date_countdown"=>Carbon::parse($discount_g->end_date)->format('M d Y H:i:s'),
        ]:null ,

    "categorie" =>   [

            "id" => $prod->subcategorie->categorie->id,
                "name" => $prod->subcategorie->categorie->name,

            ],
            "subcategorie" =>   [

                "id" => $prod->subcategorie->id,
                "name" => $prod->subcategorie->name,

            ],
            "brand"=>[

                "id" => $prod->brand->id??0,
                "name" => $prod->brand->name??'',

            ],
            "unit"=>[

                "id" => $prod->unit->id,
                "name" => $prod->unit->name,

            ],



            "inventory_type"=>[

                "id" => $prod->inventory_type->id,
                "code" => $prod->inventory_type->code,

            ],

            "variant_cover"=>

                [
                    // "product_variant_attribute_id"=>  $var->product_variant_attribute_id,
                    // "product_variant_dimension_id"=>   $var->product_variant_dimension_id,
                    "id"=>$var->id,
                    "dimension"=>($var->product_variant_dimension_id)?$var->product_variant_dimension->name:null,
                    "attribute"=>($var->product_variant_attribute_id)? $var->product_variant_attribute->name:null,
                    "cover"=>  $var->cover,
                    "minimum_quantity"=>  $var->minimum_quantity,
                    "sku"=>  $var->sku,

                    "imagen"=>
                    ($inventory_type_code=='MULTIPLE') ?
                    (
                        file_exists(  $companie_path_public  .'\\products\\'. $var->product_id.'\\variants\\'.   $var->id. "\\".   $var->image)?
                        [
                            "url"=> $companie_path_url."/products/". $var->product_id. "/variants/".   $var->id.  "/".    $var->image ,
                        ]:
                        [
                        "url"=> $companie_path_url ."/products/" . "noimage.png",
                        ]
                    ):
                    ( file_exists( $companie_path_public  .'\\products\\'.     $var->image )?

                        [

                                "url"=> $companie_path_url."/products/".     $var->image ,
                        ]:
                        [
                        "url"=> $companie_path_url ."/products/" . "noimage.png",
                        ]
                     )
                    ,



                    "product_variant_state"=>[

                        "id" => $var->product_variant_state->id,
                        "code" => $var->product_variant_state->code,
                        "name" => $var->product_variant_state->name,

                    ],
                    "inventory"=>   ($var->inventory)?
                    [
                        "price"=>$var->inventory->price,
                        "stock"=>$var->inventory->stock,
                        "available"=>$var->inventory->available,
                    ]:[
                        "price"=>0,
                        "stock"=>0,
                        "available"=>0,
                    ]

            ]

              ,

              "variants"=>

              $prod->variants-> map( function($var )use( $companie_path_url, $companie_path_public, $inventory_type_code)  {


            return      [
                      // "product_variant_attribute_id"=>  $var->product_variant_attribute_id,
                      // "product_variant_dimension_id"=>   $var->product_variant_dimension_id,
                      "id"=>$var->id,
                      "dimension"=>($var->product_variant_dimension_id)?$var->product_variant_dimension->name:null,
                      "attribute"=>($var->product_variant_attribute_id)? $var->product_variant_attribute->name:null,
                      "cover"=>  $var->cover,
                      "minimum_quantity"=>  $var->minimum_quantity,
                      "sku"=>  $var->sku,
                       "test"=>$inventory_type_code,
                     "imagen"=>
                      ($inventory_type_code=='MULTIPLE')?
                     (


                        file_exists(  $companie_path_public  .'\\products\\'. $var->product_id.'\\variants\\'.   $var->id. "\\".   $var->image)?
                        [
                            "url"=> $companie_path_url."/products/". $var->product_id. "/variants/".   $var->id.  "/".    $var->image ,
                        ]:
                        [
                        "url"=> $companie_path_url ."/products/" . "noimage.png",
                        ]
                    )
                       :
                    (
                     file_exists( $companie_path_public  .'\\products\\'.     $var->image )?
                      [

                              "url"=> $companie_path_url."/products/".     $var->image ,
                      ]:
                      [
                      "url"=> $companie_path_url ."/products/" . "noimage.png",
                      ]
                    )
                      ,



                      "product_variant_state"=>[

                          "id" => $var->product_variant_state->id,
                          "code" => $var->product_variant_state->code,
                          "name" => $var->product_variant_state->name,

                      ],
                      "inventory"=>   ($var->inventory)?
                      [
                          "price"=>$var->inventory->price,
                          "stock"=>$var->inventory->stock,
                          "available"=>$var->inventory->available,
                      ]:[
                          "price"=>0,
                          "stock"=>0,
                          "available"=>0,
                      ]

                      ];


              }),



            ];

   // });//TERMINA

    }
}
