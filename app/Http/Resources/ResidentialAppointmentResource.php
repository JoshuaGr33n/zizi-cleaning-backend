<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ResidentialAppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $availability = $this->availability;
        // Check if availability is not null and primary_date is set
        if ($availability && isset($availability['primary_date'])) {
            $availability['primary_date'] = Carbon::parse($availability['primary_date'])->format('F jS Y');

            isset($availability['secondary_date']) ? $availability['secondary_date'] = Carbon::parse($availability['secondary_date'])->format('F jS Y') : null;
        }
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'client' => $this->first_name . ' ' . $this->last_name,
            'flag' => $this->flag,
            'reference_number' => $this->reference_number,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'service_details' => $this->service_details,
            'availability' => $availability,
            'extras' => $this->extras,
            'extras_2' => $this->extras_2,
            'additional_instructions' => $this->additional_instructions,
            'image_paths' => $this->image_paths ? array_map(function ($image) {
                return asset('storage/' . $image);
            }, $this->image_paths) : [],
            'status' => ucfirst(strtolower($this->status)),
            'status_updated_at' => $this->status_updated_at ? Carbon::parse($this->status_updated_at)->format('F jS Y,  h:i A') : null,
            'created_at' => $this->created_at->format('F jS Y, h:i A'),
            'read' => $this->read,
            'updated_by' => $this->when($this->updated_by, function () {
                return $this->updatedBy ? $this->updatedBy->first_name.' '.$this->updatedBy->last_name : 'Client';
            }, 'Client'),
        ];
    }
}
