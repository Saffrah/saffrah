@component('mail::message')
# Your OTP for Password Reset

Your OTP is **{{ $data }}**.

This OTP is valid for 10 minutes.

Thanks,<br>
{{ config('app.name') }}

@component('mail::panel')
    If you did not request a password reset, please ignore this email.
@endcomponent

@component('mail::footer')
    © {{ now()->year }} {{ config('app.name') }}. All rights reserved.
@endcomponent
@endcomponent