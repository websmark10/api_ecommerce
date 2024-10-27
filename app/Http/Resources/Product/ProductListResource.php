<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $folder_companie=$request->folder_companie ;
        $variantCover=  $this->resource->variant_cover;

        $inventoryCover=$variantCover->inventory()? $variantCover->inventory()  ->first():null;

        $companie_path_url=  $this->companie_path_url();
        $companie_path_public= $this->companie_path_public() ;

       $inventory_type_code= $this->resource->inventory_type->code;


       //  return parent::toArray($request);
        return [
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
        // "tax"=>[

        //     "id" => $this->resource->tax->id,
        //     "name" => $this->resource->tax->name,

        // ],
        // "prodstate"=>[

        //     "id" => $this->resource->prodstate->id,
        //     "code" => $this->resource->prodstate->code,

        // ],
        "state"=>[

            "id" => $this->resource->state->id,
            "code" => $this->resource->state->code,

        ],
        "inventory_type"=>[

            "id" => $this->resource->inventory_type->id,
            "code" => $this->resource->inventory_type->code,

        ],

        "inventory_cover"=>[
            "batch"=> $inventoryCover->batch->file_name,
           "price"=> $inventoryCover->price , //* $inventoryCover->product_variant->product ->companie->currencie()->exchange_rate
           "cost"=> $inventoryCover->cost,
           "stock"=> $inventoryCover->stock,
           "available"=> $inventoryCover->available,
           "manufactured_date"=> $inventoryCover->manufactured_date,
           "expiry_date"=> $inventoryCover->expiry_date,
           ],
       /*  "imagen"=>[
            "url"=> env("APP_URL")."/storage/products/" . "noimage.png",
            "name"=>   $this->resource->imagen,
             "size"=> filesize( public_path("storage\\products\\" . "noimage.png" ))
           // "size"=>  (string)filesize(public_path("storage\\products\\" . $this->resource->imagen ))
         ],*/
         "imagen"=>$this->image_cover(),

         "variants"=>
         $this->resource->variants-> map( function($var )use( $companie_path_url, $companie_path_public, $inventory_type_code)  {


       return      [
                 // "product_variant_attribute_id"=>  $var->product_variant_attribute_id,
                 // "product_variant_dimension_id"=>   $var->product_variant_dimension_id,
                 "id"=>$var->id,
                 "cover"=>  $var->cover,
                 "dimension"=>($var->product_variant_dimension_id)?$var->product_variant_dimension->name:null,
                 "attribute"=>($var->product_variant_attribute_id)? $var->product_variant_attribute->name:null,
                /*  minimum_quantity"=>  $var->minimum_quantity,
                 "sku"=>  $var->sku,
                  "test"=>$inventory_type_code,*/
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
                 ];

                }),


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
