
@php use Illuminate\Support\Str; @endphp


@component('mail::message')

<p style="text-align: center;">
    <img src="{{ config('app.frontend_url') . '/img/logo.5e7c430f.jpeg' }}" alt="{{ config('app.name') }} Logo" style="width: 30%;height:auto">
</p>


# Your Login Credential

Hello {{ $user->first_name }} {{ $user->last_name }},

Your new Login Credentails are ready. Change your password immediately

**Name**: {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}

**Username**: {{ $user->username }}

**Email**: {{ $user->email }}

**Phone**: {{ $user->phone }}

**Password**: {{ $password }}


@component('mail::button', ['url' => config('app.frontend_url') . '/forgot-password'])
Reset Your Password
@endcomponent


{{ config('app.name') }}
@endcomponent
