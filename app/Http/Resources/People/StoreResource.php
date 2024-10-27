<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

       return  [
        "id"=> $this->resource->id,
        "name"=> $this->resource->name,
        "address"=>$this->resource->address ,
        "phone"=> $this->resource->phone,
        "whatsapp"=> $this->resource->whatsapp,
        "url_lan_printer"=> $this->resource->url_lan_printer,
        "url_printer"=> $this->resource->url_printer,
        "country_id"=> $this->resource->country_id,
        "google_maps"=> $this->resource->google_maps
       ];
    }
}
