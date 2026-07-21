<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'genre' => $this->genre,
            'description' => $this->description,
            'start_age' => $this->start_age,
            'issue' => $this->issue,
            'time' => $this->time,
            'cover' => $this->cover,
            'actors' => $this->actors
        ];
    }
}
