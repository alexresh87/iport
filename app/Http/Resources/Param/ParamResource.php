<?php

namespace App\Http\Resources\param;

use Illuminate\Http\Resources\Json\JsonResource;

class ParamResource extends JsonResource
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
            'offer_id' => $this->offer_id,
            'param_id' => $this->param_id,
            'param_name' => $this->getNameById($this->param_id)->title,
            'value' => $this->value
        ];
    }
}
