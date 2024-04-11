{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
@php use Illuminate\Support\Str; @endphp


@component('mail::message')

{{-- ![{{ config('app.name') }} Logo]({{ config('app.frontend_url') . '/img/logo.5e7c430f.jpeg' }} "Logo") --}}

<!-- Raw HTML with inline styles -->
<p style="text-align: center;">
    <img src="{{ config('app.frontend_url') . '/img/logo.5e7c430f.jpeg' }}" alt="{{ config('app.name') }} Logo" style="width: 30%;height:auto">
</p>


# Appointment Booked

Congratulations, {{ $appointment->first_name }}! Your appointment has been scheduled.

**Client**: {{ $appointment->first_name }} {{ $appointment->last_name }}

**Appointment Type**: {{ ucwords($appointment->flag) }}

**Reference Number**: {{ $appointment->reference_number }}


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

**Service Details**: <br>
Home Size: {{ $appointment->service_details['home_size'] }}<br>
Bathrooms: {{ $appointment->service_details['bathrooms'] }}<br>

**Availability**: <br>
Primary Date: {{ \Carbon\Carbon::parse($appointment->availability['primary_date'])->format('F jS Y') }}<br>
Secondary Date: {{ \Carbon\Carbon::parse($appointment->availability['secondary_date'])->format('F jS Y') }}<br>
Time Preferences: {{ implode(', ', $appointment->availability['time_preferences']) }}

**Additional Instructions**: {{ $appointment->additional_instructions }}

**Extras**: <br>
@foreach ($appointment->extras as $extra)
    @if (isset($extrasMapping[$extra]))
        {{ $extrasMapping[$extra] }}<br>
    @endif
@endforeach


**Others**:
Preferred Entry Method: {{ $entryMethodMapping[$appointment->extras_2['entry_method']] ?? 'N/A' }}<br>
Home Status: {{ $homeStatusOptions[$appointment->extras_2['home_status']] ?? 'N/A' }}<br>
Presence of Pets: {{ $petsStatusOptions[$appointment->extras_2['pets']] ?? 'N/A' }}<br>
Basement Cleaning Required?: {{ $basementCleaningStatusOptions[$appointment->extras_2['basement']] ?? 'N/A' }}<br>



**Booked**: {{ $appointment->created_at->format('F jS Y, h:i A') }}

**Status**: {{ ucfirst($appointment->status) }}

@php
$imageUrls = array_map(function ($path) {
    return asset(Str::replaceFirst('public/', 'storage/', $path));
}, $appointment->image_paths);
@endphp

@foreach ($imageUrls as $imageUrl)
{{-- ![Image]({{ $imageUrl }} "Image") --}}
<p style="text-align: center;">
    <img src="{{$imageUrl}}" alt="image" style="width: 50%;">
</p>
@endforeach

{{-- @foreach ($appointment->image_paths as $imagePath)
![Image Description]( {{ asset('storage/' . $imagePath) }} )
@endforeach --}}

{{-- @component('mail::button', ['url' => url('/appointment-confirmation/'.$appointment->id)]) --}}
@component('mail::button', ['url' => config('app.frontend_url') . '/appointment-confirmation/'.$appointment->id])
View Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
