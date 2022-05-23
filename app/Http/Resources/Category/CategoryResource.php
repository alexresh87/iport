<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Offer\OfferCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    //public static $wrap = 'result';
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
            'parentId' => $this->parentId,
            'title' => $this->title,
            'offers' => new OfferCollection($this->offers)
        ];
    }
}
