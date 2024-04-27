<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ContactMessageResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone ?: 'N/A',
            'email' => $this->email,
            'message' => $this->message,
            'read_unread' => $this->read_unread,
            'created_at' => Carbon::parse($this->created_at)->format('F jS Y'),
        ];
    }
}
