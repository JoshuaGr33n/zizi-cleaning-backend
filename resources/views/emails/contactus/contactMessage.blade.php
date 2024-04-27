
@php use Illuminate\Support\Str; @endphp


@component('mail::message')

<p style="text-align: center;">
    <img src="{{ config('app.frontend_url') . '/img/logo.5e7c430f.jpeg' }}" alt="{{ config('app.name') }} Logo" style="width: 30%;height:auto">
</p>


# Message


**Name**: {{ $user->name }}


**Email**: {{ $user->email }}

**Phone**: {{ $user->phone }}

**Message**: {{ $user->message }}




{{ config('app.name') }}
@endcomponent
