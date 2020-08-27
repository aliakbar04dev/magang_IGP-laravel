<p>
	{{ salam() }} {{ $user->name }}, 
</p>

<p>
	Admin Kami telah mendaftarkan Anda ke {{ config('app.name', 'Laravel') }}. Untuk login, silahkan kunjungi <a href="{{ $login = url('login') }}">{{ $login }}</a>.
</p>

<p>
	Setelah itu, silahkan login dengan menggunakan: <br>
	Username: <strong>{{ $user->username }}</strong> <br>
	Email: <strong>{{ $user->email }}</strong> <br>
	Password: <strong>{{ $password }}</strong>
</p>

@if (strlen($user->username) == 5)
<p>
	<strong>Anda juga bisa login menggunakan password aplikasi Intranet atau IGPro.</strong>
</p>
@endif

<p>
	Jika Anda ingin mengubah password, silahkan kunjungi <a href="{{ $reset = url('password/reset') }}">{{ $reset }}</a> dan masukan email Anda.
</p>