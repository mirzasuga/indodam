@component('mail::message')
# Pendaftaran Berhasil

Terima Kasih {{ $name }} sudah mendaftar di INDODAM.

Berikut ini adalah detail akun anda:

Nama        : {{ $name }}<br>
Username    : {{ $username }}<br>
Email       : {{ $email }}<br>
Phone       : {{ $phone }}<br>

<br>
<br>
<br>
<br>
Best Regards,<br>
{{ config('app.name') }}
@endcomponent