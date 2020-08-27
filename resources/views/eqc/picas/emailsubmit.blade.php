<p>
	{{ salam() }},
</p>

<p>
	Terdapat PICA dengan No: <strong>{{ $pica->no_pica }}</strong> yang telah disubmit oleh {{ $pica->nama($pica->submit_pic) }} ({{ $pica->submit_pic }}). Mohon untuk segera ditindaklanjuti.
</p>

<p>
	Untuk melihat detail PICA tsb silahkan masuk ke <a href="{{ $login = str_replace('iaess','vendor', url('login')) }}">{{ str_replace('iaess','vendor', $login) }}</a>.
</p>

<p>
	Terima kasih atas perhatian dan kerjasamanya.
</p>

<p>
	Salam,<br><br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }}) ({{ Auth::user()->nm_supp }})
</p>

<p>
	********************************************************************************************************<br>
	<strong>Note: Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>