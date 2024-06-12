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
            'DT_RowId'  => $this->id,
            'date'      => $this->date,
            'number'    => $this->number,
            'amount'    => $this->amount,
            'cost'      => $this->cost,
            'revenue'   => $this->revenue,
            'status'    => $this->status,
            'desc'      => $this->desc,
            'image'     => $this->image,
            'user_id'   => $this->user_id,
            'from_id'   => $this->from_id,
            'to_id'     => $this->to_id,
            'user'      => new UserResource($this->whenLoaded('user')),
            'from'      => new DompetResource($this->whenLoaded('from')),
            'to'        => new DompetResource($this->whenLoaded('to')),
        ];
    }
}
