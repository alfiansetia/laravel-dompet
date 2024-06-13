<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenditureResource extends JsonResource
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
            'id'            => $this->id,
            'DT_RowId'      => $this->id,
            'date'          => $this->date,
            'number'        => $this->number,
            'amount'        => $this->amount,
            'status'        => $this->status,
            'desc'          => $this->desc,
            'user_id'       => $this->user_id,
            'dompet_id'     => $this->dompet_id,
            'user'          => new UserResource($this->whenLoaded('user')),
            'dompet'        => new DompetResource($this->whenLoaded('dompet')),
            'image'         => $this->image,
        ];
    }
}
