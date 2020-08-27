<p>
	{{ salamEng() }} {{ $user->name }}, 
</p>

<p>
	You have been registered in {{ explode(' ', config('app.name', 'Laravel'))[1] }} {{ explode(' ', config('app.name', 'Laravel'))[0] }}.<br>
	Please login to <a href="{{ $login = url('login') }}">{{ $login }}</a>, using following username:<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username: <strong>{{ $user->username }}</strong> <br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email: <strong>{{ $user->email }}</strong> <br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password: <strong>{{ $password }}</strong> <br>
	You can change the password through <a href="{{ $reset = url('password/reset') }}">{{ $reset }}</a>  and please enter your registered e-mail.
</p>