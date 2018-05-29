@component('mail::message')
# Pendaftaran Berhasil

Terima Kasih {{ $name }} sudah mendaftar di INDODAM.

Best Regards,<br>
{{ config('app.name') }}
@endcomponent