<?php

namespace App\Http\Resources\Ecommerce\Product\Home;

//use Illuminate\Http\Request;
use App\Models\Product\ProductVariation;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TrendingProductHomeEcommerceResource extends JsonResource
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
                 $discount_collect->push($item->discount);
            }

/*
            foreach ( $prod->discount_categories as $key => $item) {
                if (!empty($item->discount))
             $discount_collect->push($item->discount);
           }
           foreach ( $prod->discount_brands as $key => $item) {
            if (!empty($item->discount))
             $discount_collect->push($item->discount);
           }
*/



              if($discount_collect->count() > 0){
                 $discount_g = $discount_collect->sortByDesc("discount")->values()->all()[0];

               }

             return [


                   "id"=>$prod->id,
                   "title"=>$prod->title  ,
                    "discount_g"=> ($discount_g)?
                   [
                        "discount_type_id"=>$discount_g->discount_type_id,
                        "discount"=>$discount_g->discount,
                        "end_date"=>$discount_g->end_date,
                        "end_date_countdown"=>Carbon::parse($discount_g->end_date)->format('M d Y H:i:s'),
                   ]:null ,
                   "variant_cover"=>
                   [

                             "imagen"=> ( $inventory_type_code=='MULTIPLE' && file_exists(  $companie_path_public  .'\\products\\'. $prod->variant_cover->product_id.'\\variants\\'.   $prod->variant_cover->id. "\\".   $prod->variant_cover->image))?
                         [
                             "url"=> $companie_path_url."/products/". $prod->variant_cover->product_id. "/variants/".   $prod->variant_cover->id.  "/".   $this->image ,
                         ]:
                         [
                         "url"=> $companie_path_url ."/products/" . "noimage.png",
                         ] ,

                         "imagen"=> (  $inventory_type_code=='INDIVIDUAL' && file_exists( $companie_path_public  .'\\products\\'.   $prod->variant_cover->product_id. "\\".   $prod->variant_cover->image ))?
                         [

                                 "url"=> $companie_path_url."/products/".   $prod->variant_cover->product_id. "\\".   $prod->variant_cover->image ,
                         ]:
                         [
                         "url"=> $companie_path_url ."/products/" . "noimage.png",
                         ]
                         ,

                             "inventory"=>   ($prod->variant_cover->inventory)?
                                             [
                                                 "price"=>$prod->variant_cover->inventory->price,
                                                 "stock"=>$prod->variant_cover->inventory->stock,
                                             ]:[
                                                 "price"=>0,
                                                 "stock"=>0,
                                             ]



                   ]     ,

                   "brand"=>[

                     "id" => $prod->brand->id??0,
                     "name" => $prod->brand->name??'',

                 ],



         ];


     }

}
