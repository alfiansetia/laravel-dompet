<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DompetResource extends JsonResource
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
            'name'          => $this->name,
            'type'          => $this->type,
            'acc_name'      => $this->acc_name,
            'acc_number'    => $this->acc_number,
            'saldo'         => $this->saldo,
            'user_id'       => $this->user_id,
            'user'          => new UserResource($this->whenLoaded('user')),
        ];
    }
}
