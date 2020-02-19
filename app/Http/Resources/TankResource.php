<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TankResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'started_at' => (string) $this->started_at,
            'user_id' => $this->user_id,
            'number' => $this->number,
            'capacity' => $this->capacity,
            'shrimps' => $this->shrimps,
            'tags' => $this->tags,
          ];
    }
}
