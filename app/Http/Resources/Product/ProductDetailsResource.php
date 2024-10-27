<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // $this->resource->folder_companie= $request->folder_companie??$this->resource->folder_companie ;
       //$this->resource->folder_companie= $this->resource->folder_companie ;
    //    $variantIndividual=  $this->resource->variants->where('product_variant_attribute_id',null)->where('product_variant_dimension_id',null)->first();
    //    $variantMultiple=  $this->resource->variants->whereNotNull('product_variant_attribute_id')->whereNotNull('product_variant_dimension_id');

    //    $variantCover=  $this->resource->variants->where('cover',1) ->first();

    //    $inventoryCover= $variantCover->inventory() ->first();

         $folder_companie= $this->folder_companie ;



       $sku=$this->resource->sku;

       $companie_path_url=  $this->companie_path_url();
       $companie_path_public= $this->companie_path_public() ;



        return [

          // "inventory_type_code"=>,
            "folder_companie"=>$this->folder_companie,
            "id"=>$this->resource->id,
            "title"=>$this->resource->title,
            "slug"=>$this->resource->slug,
            "sku"=>$this->resource->sku,
            "tags"=>$this->resource->tags,
            "tags_a"=>$this->resource->tags ? explode(",",$this->resource->tags):[],
           // "price"=>$this->resource->price,
           // "price_usd"=>$this->resource->price_usd,
            "summary"=>$this->resource->summary,
            "description"=>$this->resource->description??"" ,

           "base_url"=>env("APP_URL"),
           "variants"=>$this->resource->variants-> map( function($var) use($companie_path_url, $companie_path_public) {

            return [
                        "id"=>$var->id,
                        "online"=>  $var->online,
                        "cover"=>  $var->cover,
                        "minimum_quantity"=>  $var->minimum_quantity,
                        "sku"=>  $var->sku,
                        "dimension"=>
                          ( $var->product_variant_dimension)?
                           [

                            "id" => $var->product_variant_dimension->id,
                            "code" => $var->product_variant_dimension->code,
                            "name" => $var->product_variant_dimension->name,
                            ]:null
                            ,
                        "attribute"=>
                          (  $var->product_variant_attribute)?
                            [

                            "id" =>   $var->product_variant_attribute->id,
                            "code" =>   $var->product_variant_attribute->code,
                            "name" =>   $var->product_variant_attribute->name,
                            ]:null
                            ,

                   // "image"=>   $var->image,
                    "product_variant_state"=>[

                        "id" => $var->product_variant_state->id,
                        "code" => $var->product_variant_state->code,
                        "name" => $var->product_variant_state->name,

                        ],

                        "imagen"=>$var-> product_imagen(),
                         "images"=>    $var->product_variant_images->map( function($img) use($companie_path_url, $companie_path_public){



                            if($this->inventory_type->code=='INDIVIDUAL')
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

                            else if($this->inventory_type->code=='MULTIPLE')


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
                              }),




                            "inventory"=>
                                        ($var->inventory)?
                                            [   "batch"=>$var->inventory->batch?->file_name,
                                                "price"=>$var->inventory->price,
                                                "cost"=>$var->inventory->cost,
                                                "stock"=>$var->inventory->stock,
                                                "available"=>$var->inventory->available,
                                                "manufactured_date"=>$var->inventory->manufactured_date,
                                                "expiry_date"=>$var->inventory->expiry_date,
                                            ]:null ,

                            //    "discount_variant_product"=> $var->getDiscountVariantProduct(),
                                //?
                         /*   [
                                "id"=>$var->getDiscount()->id,
                                "code"=>$var->getDiscount()->code,
                                "discount_type"=>
                                [
                                        "id" =>$var->getDiscount()->discount_type->id,
                                        "code" =>$var->getDiscount()->discount_type->code,
                                ],
                                "value"=>$var->getDiscount()->discount,
                            ]:null
                        */

                          /*  "discount_variant"=> $var->getDiscountVariantAttribute()?
                            [
                                "id"=>$var->getDiscountVariantAttribute()->id,
                                "code"=>$var->getDiscountVariantAttribute()->code,
                                "discount_type"=>
                                [
                                        "id" =>$var->getDiscountVariantAttribute()->discount_type->id,
                                        "code" =>$var->getDiscountVariantAttribute()->discount_type->code,
                                ],
                                "value"=>$var->getDiscountVariantAttribute()->discount,
                            ]:null
                            */



                        ];

            }),

           "minimum_quantity"=>$this->resource-> minimum_quantity,
            "stock"=>$this->resource-> stock,
           // "checked_inventario"=>$this->resource->type_inventario,

           "inventory_type"=>[

            "id" => $this->resource->inventory_type->id,
            "code" => $this->resource->inventory_type->code,

          ],

        /*  "imagens_variants"=>

          $this->resource->variants-> map( function($img) use($companie_path_url, $companie_path_public){

              if($this->inventory_type->code=='INDIVIDUAL')
              return    (  file_exists(  $companie_path_public  .'\\products\\'.   $img->product_id. "/"  .$img->image  ))?
                         [
                               "cover"=>$img->cover ,
                               "url"=>  $companie_path_url."/products/".   $img->product_id. "/" .  $img->image ,
                              "name"=>    $img->image ,
                              "size"=>  (string)filesize(  $companie_path_public ."\\products\\".   $img->product_id. "/" .$img->image )

                          ] :
                          [
                          "cover"=>$img->cover ,
                          "url"=> $companie_path_url ."/products/" . "noimage.png",
                          "name"=>  $img->image ,
                          "size"=> (string) filesize( $companie_path_public ."\\products\\" . "noimage.png")
                          ] ;

              else if($this->inventory_type->code=='MULTIPLE')
              return    (  file_exists(  $companie_path_public  .'\\products\\'.   $img->product_id. "\\variants\\". $img->id."\\"  .$img->image  ))?
                    [
                      "cover"=>$img->cover ,
                         "url"=>  $companie_path_url."/products/".   $img->product_id. "/variants/". $img->id."/"  .$img->image ,
                        "name"=>    $img->image ,
                        "size"=>  (string)filesize(  $companie_path_public .'\\products\\'.   $img->product_id. "\\variants\\". $img->id."\\"  .$img->image  )
                    ] :
                    [
                      "cover"=>$img->cover ,
                    "url"=> $companie_path_url ."/products/" . "noimage.png",
                    "name"=>  $img->imagen.".jpg" ,
                    "size"=> (string) filesize( $companie_path_public ."\\products\\" . "noimage.png")
                    ] ;
                })

         ,
*/
             /*   ,"discount_variant"=>$this->resource->variants()->getDiscountProductVariantAttribute()?
                [

                    "id"=>$this->resource->getDiscountProductVariantAttribute()->id,
                    "code"=>$this->resource->getDiscountProductVariantAttribute()->code,
                   // "type"=>$this->resource->getDiscountProductVariantAttribute()->type->code,
                   // "discount_type"=>$this->resource->getDiscountProductVariantAttribute()->discount_type->name,
                    "discount_type"=>
                    [
                             "id" =>$this->resource->getDiscountProductVariantAttribute()->discount_type->id,
                             "code" =>$this->resource->getDiscountProductVariantAttribute()->discount_type->code,
                            // "name"=> $this->resource->getDiscountProductVariantAttribute()->discount_type->name,
                    ],
                    "value"=>$this->resource->getDiscountProductVariantAttribute()->discount,

                ]:null,*/

         /* ,"discount_product"=>$this->resource->getDiscountProdAttribute()?
           [

               "id"=>$this->resource->getDiscountProdAttribute()->id,
               "code"=>$this->resource->getDiscountProdAttribute()->code,
              // "type"=>$this->resource->getDiscountProdAttribute()->type->code,
              // "discount_type"=>$this->resource->getDiscountProdAttribute()->discount_type->name,
               "discount_type"=>
               [
                        "id" =>$this->resource->getDiscountProdAttribute()->discount_type->id,
                        "code" =>$this->resource->getDiscountProdAttribute()->discount_type->code,
                       // "name"=> $this->resource->getDiscountProdAttribute()->discount_type->name,
               ],
               "value"=>$this->resource->getDiscountProdAttribute()->discount,

           ]:null,*/

           "discount_categorie"=>
             $this->resource->getDiscountCategorieAttribute()?

            [
                "id"=>$this->resource->getDiscountCategorieAttribute()->id,
                "code"=>$this->resource->getDiscountCategorieAttribute()->code,
            // "type"=>$this->resource->getDiscountCategorieAttribute()->type->name,
                "discount_type"=>
                [
                        "id" =>$this->resource->getDiscountCategorieAttribute()->discount_type->id,
                        "code" =>$this->resource->getDiscountCategorieAttribute()->discount_type->code,
                        // "name"=> $this->resource->getDiscountCategorieAttribute()->discount_type->name,
                ],
                "value"=>$this->resource->getDiscountCategorieAttribute()->discount,


            ]:NULL,

           "supercategorie" =>   [
            "id" => $this->resource->subcategorie->categorie->supercategorie->id,
              "icono" => $this->resource->subcategorie->categorie->supercategorie->icono,
              "name" => $this->resource->subcategorie->categorie->supercategorie->name,

        ],

          "categorie" =>   [

            "id" => $this->resource->subcategorie->categorie->id,
            "icono" => $this->resource->subcategorie->categorie->icono,
            "name" => $this->resource->subcategorie->categorie->name,

        ],
        "subcategorie" =>   [

            "id" => $this->resource->subcategorie->id,
            "name" => $this->resource->subcategorie->name,

        ],
        "brand"=>[

             "id" => $this->resource->brand->id??0,
            "name" => $this->resource->brand->name??'',

        ],
        "unit"=>[

            "id" => $this->resource->unit->id,
            "name" => $this->resource->unit->name,

        ],
        "tax_type" =>   [

            "id" => $this->resource->tax->tax_type->id,
            "name" => $this->resource->tax->tax_type->name,

        ],
        "tax"=>[

            "id" => $this->resource->tax->id,
            "name" => $this->resource->tax->name,

        ],

        "state"=>[

            "id" => $this->resource->state->id,
            "code" => $this->resource->state->code,

        ],
        "inventory_type"=>[

            "id" => $this->resource->inventory_type->id,
            "code" => $this->resource->inventory_type->code,

        ],
            "stamps"=> [
                "created_at"=>$this->resource->created_at??'',
                "updated_at"=>$this->resource->updated_at??'',
                "deleted_at"=>$this->resource->deleted_at??'',
                "created_by"=>$this->resource->creator->name??'',
                "updated_by"=>$this->resource->editor->name??'',
                "deleted_by"=>$this->resource->destroyer->name??'',
                // "img_created"=>  env("APP_URL")."/storage/companies/".$this->resource->folder_companie."/users/". ( $this->resource->user_created->avatar?? 'default.png'),
                // "img_updated"=> env("APP_URL")."/storage/companies/".$this->resource->folder_companie."/users/". ( $this->resource->user_updated->avatar?? 'default.png'),

                "img_created"=>
                !empty($this->resource->user_created->avatar)?
                         env("APP_URL")."/storage/companies/".$this->resource->folder_companie."/users/".  $this->resource->user_created->avatar:'',


                         "img_updated"=>
                         !empty($this->resource->user_updated->avatar)?
                                  env("APP_URL")."/storage/companies/".$this->resource->folder_companie."/users/".  $this->resource->user_updated->avatar:'',

            ],
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
