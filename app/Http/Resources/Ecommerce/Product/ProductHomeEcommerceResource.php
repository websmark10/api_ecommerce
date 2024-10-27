<?php

namespace App\Http\Resources\Ecommerce\Product;

//use Illuminate\Http\Request;
use App\Models\Product\ProductVariation;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProductHomeEcommerceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     public function toArray($request){


        $prod= $this->resource;


             $companie_path_url= $prod->companie->companie_path_url();
             $companie_path_public=$prod->companie->companie_path_public() ;

             $inventory_type_code=$prod->inventory_type->code;



            $discount_g=null ;

            $discount_collect = collect([]);
            foreach ( $prod->discount_products  as $key => $item) {
                if($item->discount->discount_method_id==1) //Descuento Normal
                    $discount_collect->push($item->discount);
                }
            foreach ( $prod->subcategorie->categorie->discount_categories as $key => $item) {
                if($item->discount->discount_method_id==1) //Descuento Normal
                $discount_collect->push($item->discount);
            }
            foreach ( $prod->discount_brands as $key => $item) {
                if($item->discount->discount_method_id==1) //Descuento Normal
                $discount_collect->push($item->discount);
            }
            if($discount_collect->count() > 0){
                 $discount_g = $discount_collect->sortByDesc("discount")->values()->all()[0];
            }

            $variantCover= $prod->variant_cover;

             return [

                    "companie_path_url"=> $companie_path_url,
                   "id"=>$prod->id,
                   "title"=>$prod->title  ,
                   "slug"=>$prod->slug  ,
                   "summary"=>$prod->summary,
                   "brand"=>[
                     "id" => $prod->brand->id??0,
                     "name" => $prod->brand->name??'',
                 ],

                    "discount_g"=> ($discount_g)?
                   [
                    "id"=>$discount_g->id,
                        "discount_type_id"=>$discount_g->discount_type_id,
                        "discount"=>$discount_g->discount,
                        "end_date"=>$discount_g->end_date,
                        "end_date_countdown"=>Carbon::parse($discount_g->end_date)->format('M d Y H:i:s'),
                   ]:null ,
                   "variant_cover"=> ($variantCover)?
                   [
                             "id"=> $variantCover->id,
                             "imagen"=>


                                    ( $inventory_type_code=='MULTIPLE' )?
                                    (
                                        file_exists(  $companie_path_public  .'\\products\\'.  $variantCover->product_id.'\\variants\\'.    $variantCover->id. "\\".    $variantCover->image)?
                                        [
                                            "url"=> $companie_path_url."/products/".  $variantCover->product_id. "/variants/".    $variantCover->id.  "/".     $variantCover->image ,
                                        ]:
                                        [
                                             "url"=> $companie_path_url ."/products/" . "noimage.png",
                                        ]
                                    )
                                    :
                                    ( file_exists( $companie_path_public  .'\\products\\'.      $variantCover->image )?

                                    [

                                            "url"=> $companie_path_url."/products/".      $variantCover->image ,
                                    ]:
                                    [
                                    "url"=> $companie_path_url ."/products/" . "noimage.png",
                                    ]
                                 )
                                    ,

                             "inventory"=>   ( $variantCover->inventory)?
                                             [
                                                 "price"=> $variantCover->inventory->price,
                                                 "stock"=> $variantCover->inventory->stock,
                                             ]:[
                                                 "price"=>0,
                                                 "stock"=>0,
                                             ]



                   ]:null

         ];


     }


    public function toArray2($request)
    {

        $discount_g = null;

        $discount_collect = collect([]);

        $discount_product =  $prod->discount_product;
        if($discount_product){
            $discount_collect->push($discount_product);
        }
        $discount_categorie = $prod->discount_categorie;
        if($discount_categorie){
            $discount_collect->push($discount_categorie);
        }
        $discount_brand =  $prod->discount_brand;
        if($discount_brand){
            $discount_collect->push($discount_brand);
        }

        if($discount_collect->count() > 0){
            $discount_g = $discount_collect->sortByDesc("discount")->values()->all()[0];
        }

        $variation_collect = collect([]);
        foreach ($prod->variations->groupBy("attribute_id") as $key => $variation_t) {
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
            "id" => $prod->id,
            "title" => $prod->title,
            "slug"  => $prod->slug,
            "sku" => $prod->sku,
            "price_pen"  => $prod->price_pen,
            "price_usd"  => $prod->price_usd,
            "resumen"  => $prod->resumen,
            "imagen"  => env("APP_URL")."storage/".$prod->imagen,
            "state"  => $prod->state,
            "description"  => $prod->description,
            "tags"  => $prod->tags ? json_decode($prod->tags) : [],
            "brand_id"  => $prod->brand_id,
            "brand" => $prod->brand ? [
                "id" => $prod->brand->id,
                "name" => $prod->brand->name,
            ]: NULL,
            "categorie_first_id"  => $prod->categorie_first_id,
            "categorie_first"  => $prod->categorie_first ? [
                "id" => $prod->categorie_first->id,
                "name" => $prod->categorie_first->name,
            ] : NULL,
            "categorie_second_id"  => $prod->categorie_second_id,
            "categorie_second"  => $prod->categorie_second ? [
                "id" => $prod->categorie_second->id,
                "name" => $prod->categorie_second->name,
            ] : NULL,
            "categorie_third_id"  => $prod->categorie_third_id,
            "categorie_third"  => $prod->categorie_third ? [
                "id" => $prod->categorie_third->id,
                "name" => $prod->categorie_third->name,
            ] : NULL,
            "stock" => $prod->stock,
            "created_at" => $prod->created_at->format("Y-m-d h:i:s"),
            "images" => $prod->images->map(function($image) {
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



        // $prod->variations->map(function($variation) {
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
