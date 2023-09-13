<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiResource extends JsonResource
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
            'id'        => $this->id,
            'date'      => $this->date,
            'amount'    => $this->amount,
            'cost'      => $this->cost,
            'revenue'   => $this->revenue,
            'status'    => $this->status,
            'desc'      => $this->desc,
            'user'      => new UserResource($this->whenLoaded('user')),
            'from'      => new DompetResource($this->whenLoaded('from')),
            'to'        => new DompetResource($this->whenLoaded('to')),
        ];
    }
}
