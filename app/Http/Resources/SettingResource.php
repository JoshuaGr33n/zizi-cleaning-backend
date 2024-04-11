<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tag' => $this->tag,
            'value' => $this->value,
            'category' => $this->category,
            'url' => $this->url,
            'desc' => $this->desc,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
        ];
    }
}
