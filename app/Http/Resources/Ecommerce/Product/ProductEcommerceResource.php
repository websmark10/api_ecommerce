<?php

namespace App\Http\Resources\Ecommerce\Product;

//use Illuminate\Http\Request;
use App\Models\Product\ProductVariation;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductEcommerceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


     public function toArray($request){


       $prod= $this->resource;

       //return $prod;

         $companie_path_url= $prod->companie->companie_path_url();
            $companie_path_public=$prod->companie->companie_path_public() ;
            // $inventoryCover=$prod->variant_cover()->inventory()? $prod->variant_cover()->inventory()  ->first():null;

            $discount_g = null;

          /*  $discount_collect = collect([]);

            $discount_product =  $this->resource->discount_product;
            if($discount_product){
                $discount_collect->push($discount_product);
            }
            $discount_categorie = $this->resource->discount_categorie;
            if($discount_categorie){
                $discount_collect->push($discount_categorie);
            }
            $discount_brand =  $this->resource->discount_brand;
            if($discount_brand){
                $discount_collect->push($discount_brand);
            }

            if($discount_collect->count() > 0){
                $discount_g = $discount_collect->sortByDesc("discount")->values()->all()[0];
            }*/
        return
        [

            "id"=>$prod->id,
             "title"=>$prod->title,
             "discount_g" => $discount_g,
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
                // "imagen"=>$prod-> image_cover(),
                 "variant_cover"=> $prod->product_variant


                //   "product_variant"=> [
                //      "imagen"=>  $prod->product_variant ,
                //      "inventory"=> $prod->product_variant->inventory
                //   ],


                // "variant_cover"=>$prod->variant_cover,

                // "variant_cover"=>$prod->variant_cover(),
                /*  "inventory_cover"=>[
                    // "batch"=> $inventoryCover->batch->file_name,
                     "price"=> $inventoryCover->price , //* $inventoryCover->product_variant->product ->companie->currencie()->exchange_rate
                    // "cost"=> $inventoryCover->cost,
                    // "stock"=> $inventoryCover->stock,
                    // "available"=> $inventoryCover->available,
                    // "manufactured_date"=> $inventoryCover->manufactured_date,
                    // "expiry_date"=> $inventoryCover->expiry_date,
                    ], */



        ];


    }

    public function toArray2($request)
    {

        $discount_g = null;

        $discount_collect = collect([]);

        $discount_product =  $this->resource->discount_product;
        if($discount_product){
            $discount_collect->push($discount_product);
        }
        $discount_categorie = $this->resource->discount_categorie;
        if($discount_categorie){
            $discount_collect->push($discount_categorie);
        }
        $discount_brand =  $this->resource->discount_brand;
        if($discount_brand){
            $discount_collect->push($discount_brand);
        }

        if($discount_collect->count() > 0){
            $discount_g = $discount_collect->sortByDesc("discount")->values()->all()[0];
        }

        $variation_collect = collect([]);
        foreach ($this->resource->variations->groupBy("attribute_id") as $key => $variation_t) {
            $variation_collect->push([
                "attribute_id" => $variation_t[0]->attribute_id,
                "attribute" => $variation_t[0]->attribute ? [
                    "name" => $variation_t[0]->attribute->name,
                    "type_attribute" => $variation_t[0]->attribute->type_attribute,
                ] : NULL,
                "variations" => $variation_t->map(function($variation) {
                    return [
                        "id" => $variation->id,
                        "product_id" => $variation->product_id,
                        "attribute_id" => $variation->attribute_id,
                        "attribute" => $variation->attribute ? [
                            "name" => $variation->attribute->name,
                            "type_attribute" => $variation->attribute->type_attribute,
                        ] : NULL,
                        "propertie_id" => $variation->propertie_id,
                        "propertie" => $variation->propertie ? [
                            "name" => $variation->propertie->name,
                            "code" => $variation->propertie->code,
                        ] : NULL,
                        "value_add" => $variation->value_add,
                        "add_price" => $variation->add_price,
                        "stock" => $variation->stock,
                        "subvariation" => $variation->variation_children->count() > 0 ? [
                            "attribute_id" => $variation->variation_children->first()->attribute_id,
                            "attribute" => $variation->variation_children->first()->attribute ? [
                                "name" => $variation->variation_children->first()->attribute->name,
                                "type_attribute" => $variation->variation_children->first()->attribute->type_attribute,
                            ] : NULL,
                        ] : null,
                        "subvariations" => $variation->variation_children->map(function($subvarion) {
                            return [
                                "id" => $subvarion->id,
                                "product_id" => $subvarion->product_id,
                                "attribute_id" => $subvarion->attribute_id,
                                "attribute" => $subvarion->attribute ? [
                                    "name" => $subvarion->attribute->name,
                                    "type_attribute" => $subvarion->attribute->type_attribute,
                                ] : NULL,
                                "propertie_id" => $subvarion->propertie_id,
                                "propertie" => $subvarion->propertie ? [
                                    "name" => $subvarion->propertie->name,
                                    "code" => $subvarion->propertie->code,
                                ] : NULL,
                                "value_add" => $subvarion->value_add,
                                "add_price" => $subvarion->add_price,
                                "stock" => $subvarion->stock,
                            ];
                        }),
                    ];
                })
            ]);
        }

        return [
            "id" => $this->resource->id,
            "title" => $this->resource->title,
            "slug"  => $this->resource->slug,
            "sku" => $this->resource->sku,
            "price_pen"  => $this->resource->price_pen,
            "price_usd"  => $this->resource->price_usd,
            "resumen"  => $this->resource->resumen,
            "imagen"  => env("APP_URL")."storage/".$this->resource->imagen,
            "state"  => $this->resource->state,
            "description"  => $this->resource->description,
            "tags"  => $this->resource->tags ? json_decode($this->resource->tags) : [],
            "brand_id"  => $this->resource->brand_id,
            "brand" => $this->resource->brand ? [
                "id" => $this->resource->brand->id,
                "name" => $this->resource->brand->name,
            ]: NULL,
            "categorie_first_id"  => $this->resource->categorie_first_id,
            "categorie_first"  => $this->resource->categorie_first ? [
                "id" => $this->resource->categorie_first->id,
                "name" => $this->resource->categorie_first->name,
            ] : NULL,
            "categorie_second_id"  => $this->resource->categorie_second_id,
            "categorie_second"  => $this->resource->categorie_second ? [
                "id" => $this->resource->categorie_second->id,
                "name" => $this->resource->categorie_second->name,
            ] : NULL,
            "categorie_third_id"  => $this->resource->categorie_third_id,
            "categorie_third"  => $this->resource->categorie_third ? [
                "id" => $this->resource->categorie_third->id,
                "name" => $this->resource->categorie_third->name,
            ] : NULL,
            "stock" => $this->resource->stock,
            "created_at" => $this->resource->created_at->format("Y-m-d h:i:s"),
            "images" => $this->resource->images->map(function($image) {
                return [
                    "id" => $image->id,
                    "imagen" => env("APP_URL")."storage/".$image->imagen,
                ];
            }),
            "discount_g" => $discount_g,
            "variations" => $variation_collect,
        ];
    }
}



        // $this->resource->variations->map(function($variation) {
        //     return [
        //         "id" => $variation->id,
        //         "product_id" => $variation->product_id,
        //         "attribute_id" => $variation->attribute_id,
        //         "attribute" => $variation->attribute ? [
        //             "name" => $variation->attribute->name,
        //             "type_attribute" => $variation->attribute->type_attribute,
        //         ] : NULL,
        //         "propertie_id" => $variation->propertie_id,
        //         "propertie" => $variation->propertie ? [
        //             "name" => $variation->propertie->name,
        //             "code" => $variation->propertie->code,
        //         ] : NULL,
        //         "value_add" => $variation->value_add,
        //         "add_price" => $variation->add_price,
        //         "stock" => $variation->stock,
        //         "variations" => $variation->variation_children->map(function($subvarion) {
        //             return [
        //                 "id" => $subvarion->id,
        //                 "product_id" => $subvarion->product_id,
        //                 "attribute_id" => $subvarion->attribute_id,
        //                 "attribute" => $subvarion->attribute ? [
        //                     "name" => $subvarion->attribute->name,
        //                     "type_attribute" => $subvarion->attribute->type_attribute,
        //                 ] : NULL,
        //                 "propertie_id" => $subvarion->propertie_id,
        //                 "propertie" => $subvarion->propertie ? [
        //                     "name" => $subvarion->propertie->name,
        //                     "code" => $subvarion->propertie->code,
        //                 ] : NULL,
        //                 "value_add" => $subvarion->value_add,
        //                 "add_price" => $subvarion->add_price,
        //                 "stock" => $subvarion->stock,
        //             ];
        //         }),
        //     ];
        // })
