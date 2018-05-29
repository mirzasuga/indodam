@component('mail::message')
# Verifikasi Permintaan Withdraw

Dear {{ $user->name }},<br>
Kami telah merekam adanya transaksi permintaan withdraw pada akun anda.

Berikut ini adalah detil permintaan withdraw yang tersimpan:<br>

Nama Akun        : {{ $user->username }}<br>
Jumlah Withdraw  : {{ $amount }}<br>
IP Address       : {{ $ipAddress }}<br>
Waktu Permintaan : {{ $createdAt }}<br>


Silahkan tekan tombol <b>Verifikasi</b> jika permintaan ini adalah sah.

@component('mail::button', ['url' => $verifyLink])
Verifikasi
@endcomponent

Best Regards,<br>
{{ config('app.name') }}
@endcomponent
