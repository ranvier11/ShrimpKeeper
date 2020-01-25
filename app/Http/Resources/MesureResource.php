<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MesureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tank_id' => $this->tank_id,
            'tempC' => $this->tempC,
            'ph' => $this->ph,
            'kh' => $this->kh,
            'gh' => $this->gh,
            'no3' => $this->no3,
            'ppm' => $this->ppm,
            'us' => $this->us,
            'created_at' => $this->created_at,
            'description' => $this->description,
          ];
    }
}
