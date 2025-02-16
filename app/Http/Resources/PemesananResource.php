<?php

namespace App\Http\Resources;

use App\Models\Penumpang;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PemesananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'jadwal' => new JadwalResource($this->whenLoaded('jadwal')),
            'penumpang' => new PenumpangResource($this->whenLoaded('penumpang')),
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
