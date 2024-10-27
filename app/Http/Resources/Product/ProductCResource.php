<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProductCResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {



       //  $request->folder_companie = $request->folder_companie?? $request->folder_companie ;

       $folder_companie=$request->folder_companie ;
      // $variantIndividual=  $this->resource->variants->where('product_variant_attribute_id',null)->where('product_variant_dimension_id',null)->first();
       $variantCover=  $this->resource->variant_cover();
      // return ["product"=>$this->variants,  "variantlCover"=>$variantCover];
      $inventoryCover=$variantCover->inventory()? $variantCover->inventory()  ->first():null;


       $companie_path_url=  $this->companie_path_url();
       $companie_path_public= $this->companie_path_public() ;



        return [

             "folder_companie_request"=> $request->folder_companie ,
            // "folder_companie_resource"=>$this->resource->folder_companie,
            "id"=>$this->resource->id,
            "title"=>$this->resource->title,
            //"subcategorie_id"=>$this->resource->subcategorie_id,
            //"categorie_id"=>$this->resource->categorie_id,
           // "categorias"=>$this->resource->categorie,
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
        "tax"=>[

            "id" => $this->resource->tax->id,
            "name" => $this->resource->tax->name,

        ],

        "state"=>[

            "id" => $this->resource->state->id,
            "code" => $this->resource->state->code,

        ],
           // "inventory"=>$inventoryCover,
            "slug"=>$this->resource->slug,
            "sku"=>$variantCover->sku,
            "tags"=>$this->resource->tags,
            "tags_a"=>$this->resource->tags ? explode(",",$this->resource->tags):[],

            "inventory_cover"=>[
             "batch"=> $inventoryCover->batch->file_name,
            "price"=> $inventoryCover->price , //* $inventoryCover->product_variant->product ->companie->currencie()->exchange_rate
            "cost"=> $inventoryCover->cost,
            "stock"=> $inventoryCover->stock,
            "available"=> $inventoryCover->available,
            "manufactured_date"=> $inventoryCover->manufactured_date,
            "expiry_date"=> $inventoryCover->expiry_date,
            ],


            // "summary"=>$this->resource->summary,
            // "description"=>$this->resource->description??"" ,

           "base_url"=>env("APP_URL"),
           "variants"=>$this->resource->variants-> map( function($var)  {

            return [
            // "product_variant_attribute_id"=>  $var->product_variant_attribute_id,
            // "product_variant_dimension_id"=>   $var->product_variant_dimension_id,


            "cover"=>  $var->cover,
            "minimum_quantity"=>  $var->minimum_quantity,
            "sku"=>  $var->sku,
           "image"=>   $var->image,
           "product_variant_state"=>[

            "id" => $var->product_variant_state->id,
            "code" => $var->product_variant_state->code,
            "name" => $var->product_variant_state->name,

        ],


            "inventory"=> ($var->inventory())?
                    [
                    //$var->inventory()->first()
                        "batch"=>$var->inventory()->first()->batch,
                        "price"=>$var->inventory()->first()->price  ,// $var->product ->companie->currencie()->exchange_rate
                        "exchange_rate"=>$var->product ->companie->currencie()->exchange_rate ,
                        "cost"=>$var->inventory()->first()->cost,
                        "stock"=>$var->inventory()->first()->stock,
                        "manufactured_date"=>$var->inventory()->first()->manufactured_date,
                        "expiry_date"=>$var->inventory()->first()->expiry_date,
                    ]:null,

                "discount_variant"=> $var->getDiscountVariantAttribute()?
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



            ];

            }),

                 "minimum_quantity"=>$this->resource-> minimum_quantity,

           // "checked_inventario"=>$this->resource->type_inventario,

           "inventory_type"=>[

            "id" => $this->resource->inventory_type->id,
            "code" => $this->resource->inventory_type->code,

        ],

        "imagen"=>$this->image_cover(),
       "imagens_variants"=>

        $this->variants->map( function($img) use($companie_path_url, $companie_path_public){

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
                        "name"=>  $img->name ,
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
                  "name"=>  $img->image.".jpg" ,
                  "size"=> (string) filesize( $companie_path_public ."\\products\\" . "noimage.png")
                  ] ;
              }),



   "images"=>

   $this->variant_cover()->product_variant_images->map( function($img) use($companie_path_url, $companie_path_public){
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
       })
   ,

/*
           "discount_categorie"=>
             $this->resource->getDiscountCatAttribute()?

            [
            "id"=>$this->resource->getDiscountCatAttribute()->id,
            "code"=>$this->resource->getDiscountCatAttribute()->code,
           // "type"=>$this->resource->getDiscountCatAttribute()->type->name,
            "discount_type"=>
            [
                      "id" =>$this->resource->getDiscountCatAttribute()->discount_type->id,
                     "code" =>$this->resource->getDiscountCatAttribute()->discount_type->code,
                    // "name"=> $this->resource->getDiscountCatAttribute()->discount_type->name,
            ],
            "value"=>$this->resource->getDiscountCatAttribute()->discount,


        ]:NULL,*/

/*
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
            }),*/
            "stamps"=> [
                "created_at"=>$this->resource->created_at??'',
                "updated_at"=>$this->resource->updated_at??'',
                "deleted_at"=>$this->resource->deleted_at??'',
                "created_by"=>$this->resource->creator->name??'',
                "updated_by"=>$this->resource->editor->name??'',
                "deleted_by"=>$this->resource->destroyer->name??'',
                // "img_created"=>  env("APP_URL")."/storage/companies/". $request->folder_companie ."/users/". ( $this->resource->user_created->avatar?? 'default.png'),
                // "img_updated"=> env("APP_URL")."/storage/companies/". $request->folder_companie ."/users/". ( $this->resource->user_updated->avatar?? 'default.png'),

                "img_created"=>
                !empty($this->resource->user_created->avatar)?
                         env("APP_URL")."/storage/companies/". $request->folder_companie ."/users/".  $this->resource->user_created->avatar:'',


                         "img_updated"=>
                         !empty($this->resource->user_updated->avatar)?
                                  env("APP_URL")."/storage/companies/". $request->folder_companie ."/users/".  $this->resource->user_updated->avatar:'',

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
