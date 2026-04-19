<x-mail::message>
# Verify Your Email Address

Please use the following 6-digit OTP code to verify your email address and activate your Mapsily account:

<x-mail::panel>
**{{ $otp }}**
</x-mail::panel>

This code will expire in 15 minutes. If you did not request this account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
