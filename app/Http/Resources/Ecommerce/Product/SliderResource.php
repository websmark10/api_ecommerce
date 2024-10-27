<?php

namespace App\Http\Resources\Ecommerce\Product;

//use Illuminate\Http\Request;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


     public function toArray($request){


       $slider= $this->resource;
  
            $companie_path_url= $slider->companie->companie_path_url();
            $companie_path_public=$slider->companie->companie_path_public() ;


        return
        [
            "id" => $slider->id,
            "title"  => $slider->title,
            "subtitle"  => $slider->subtitle,
            "label"  => $slider->label,
             "imagen"  => $slider->imagen ?  $companie_path_url ."/sliders/".$slider->imagen: NULL,
            "link"  => $slider->link,
            //"state"  => $slider->state,
            "state_id" =>    $slider-> state_id ,
            "color"  => $slider->color,
            "type_slider_id"=> $slider->type_slider_id,
            //"type_slider"  => $slider->type_slider,
            "price_original"  => $slider->price_original,
            "price_campaing" => $slider->price_campaing,


        ];


    }

}


