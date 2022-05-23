<?php

namespace App\Http\Resources\Offer;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'available' => $this->available,
            'url' => $this->url,
            'price' => $this->price,
            'currencyId' => $this->currencyId,
            'categoryId ' => $this->categoryId ,
            'store' => $this->store,
            'pickup' => $this->pickup,
            'delivery' => $this->delivery,
            'model' => $this->model,
            'typePrefix' => $this->typePrefix,
            'vendor' => $this->vendor,
            'description' => $this->description,
            'barcode' => $this->barcode,
        ];
    }
}
