Klik link berikut untuk melakukan aktivasi akun {{ config('app.name', 'Laravel') }}:
<a href="{{ $link = url('auth/verify', $token).'?email='.urlencode($user->email) }}"> {{ $link }} </a>