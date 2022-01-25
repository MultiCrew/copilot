<?php

namespace App\Http\Resources\Flights;

use Illuminate\Http\Resources\Json\JsonResource;

class AircraftResource extends JsonResource
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
            'icao' => $this->icao,
            'name' => $this->name,
            'sim' => $this->sim
        ];
    }
}
