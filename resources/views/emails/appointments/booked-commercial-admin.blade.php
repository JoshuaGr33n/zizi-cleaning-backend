
@php use Illuminate\Support\Str; @endphp


@component('mail::message')

<p style="text-align: center;">
    <img src="{{ config('app.frontend_url') . '/img/logo.5e7c430f.jpeg' }}" alt="{{ config('app.name') }} Logo" style="width: 30%;height:auto">
</p>


# New Appointment Booked

New Appointment Request from {{ $appointment->first_name }} {{ $appointment->last_name }}!

**Client**: {{ $appointment->first_name }} {{ $appointment->last_name }}

**Appointment Type**: {{ ucwords($appointment->flag) }}

**Reference Number**: {{ $appointment->reference_number }}

@if(isset($appointment->company_name))
**Company Name**: {{ $appointment->company_name }}
@endif

**Email**: {{ $appointment->email }}

**Phone**: {{ $appointment->phone }}

**Address**: <br>
Street 1: {{ $appointment->address['street1'] }}<br>
@if(isset($appointment->address['street2']))
Street 2: {{ $appointment->address['street2'] }}<br>
@endif
City: {{ $appointment->address['city'] }}<br>
Province: {{ $appointment->address['province'] }}<br>
Postal Code: {{ $appointment->address['postal_code'] }}<br>

**Service Details**:
 {{ $appointment->service_details['information'] }}

**Availability**: <br>
Primary Date: {{ \Carbon\Carbon::parse($appointment->availability['primary_date'])->format('F jS Y') }}<br>
Secondary Date: {{ \Carbon\Carbon::parse($appointment->availability['secondary_date'])->format('F jS Y') }}<br>
Time Preferences: {{ implode(', ', $appointment->availability['time_preferences']) }}

**Additional Instructions**: {{ $appointment->additional_instructions }}

**Booked**: {{ $appointment->created_at->format('F jS Y, h:i A') }}

**Status**: {{ ucfirst($appointment->status) }}

@php
$imageUrls = array_map(function ($path) {
    return asset(Str::replaceFirst('public/', 'storage/', $path));
}, $appointment->image_paths);
@endphp

@foreach ($imageUrls as $imageUrl)

<p style="text-align: center;">
    <img src="{{$imageUrl}}" alt="image" style="width: 50%;">
</p>
@endforeach




@component('mail::button', ['url' => config('app.frontend_url') . '/commercial-appointment-view/'.$appointment->id])
View Details
@endcomponent


{{ config('app.name') }}
@endcomponent
