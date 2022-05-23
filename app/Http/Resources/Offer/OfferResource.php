<?php

namespace App\Http\Resources\Offer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Picture\PictureCollection;
use App\Http\Resources\Param\ParamCollection;

class OfferResource extends JsonResource
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
            'market_category' => $this->market_category,
            'store' => $this->store,
            'pickup' => $this->pickup,
            'delivery' => $this->delivery,
            'delivery-options' => $this->{'delivery-options'},
            'model' => $this->model,
            'typePrefix' => $this->typePrefix,
            'vendor' => $this->vendor,
            'description' => $this->description,
            'vendorCode' => $this->vendorCode,
            'sales_notes' => $this->sales_notes,
            'barcode' => $this->barcode,
            'pictures' => new PictureCollection($this->pictures),
            'params' => new ParamCollection($this->params)
        ];
    }
}
