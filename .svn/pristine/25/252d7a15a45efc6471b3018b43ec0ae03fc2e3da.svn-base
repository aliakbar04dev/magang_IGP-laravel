<p>
	{{ salam() }},
</p>

<p>
	Terdapat Register PP dari bagian {{ $ppReg->nm_dept }} ({{ $ppReg->kd_dept_pembuat }}) yang dibuat oleh {{ Auth::user()->name }} ({{ Auth::user()->username }}) dengan detail sebagai berikut:
</p>

<p>
	- Pemakai: {{ $ppReg->pemakai }}.<br>
	- Untuk: {{ $ppReg->untuk }}.<br>
	- Alasan: {{ $ppReg->alasan }}.<br>
</p>

<p>
	Untuk detail barangnya dapat masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
</p>

<p>
	Terima Kasih.
</p>

<p>
	<strong>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel').' TRIAL' }}</strong>
</p>