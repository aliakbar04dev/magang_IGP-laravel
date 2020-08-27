<p>
	{{ salam() }},
</p>

<p>
	Telah disetujui Register PP bagian {{ $ppReg->nm_dept }} ({{ $ppReg->kd_dept_pembuat }}) oleh Divisi Head ({{ Auth::user()->name }} - {{ Auth::user()->username }}) dengan detail sebagai berikut:
</p>

<p>
	- Pemakai: {{ $ppReg->pemakai }}.<br>
	- Untuk: {{ $ppReg->untuk }}.<br>
	- Alasan: {{ $ppReg->alasan }}.<br>
	- Supplier: {{ $ppReg->namaSupp($ppReg->kd_supp) }} ({{ $ppReg->kd_supp }}).
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