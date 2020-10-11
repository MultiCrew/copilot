<?php

namespace App\Http\Resources\Flights;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'plan_id' => $this->plan_id,
            'code' => $this->when(Auth::id() == $this->requestee_id || Auth::id() == $this->acceptee_id, $this->code),
            'public' => $this->public,
            'departure' => $this->departure,
            'arrival' => $this->arrival,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'expiry' => $this->expiry,
            'aircraft' => new AircraftResource($this->aircraft),
            'requestee' => new UserResource($this->requestee),
            'acceptee' => new UserResource($this->acceptee)
        ];
    }
}
