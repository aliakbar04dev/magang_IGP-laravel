<p>
	{{ salam() }},
</p>

<p>
	Mohon maaf, {{ $ppReg->nama($ppReg->npk_reject) }} ({{ $ppReg->npk_reject }}) telah menolak Register PP Anda dengan No: <strong>{{ $ppReg->no_reg }}</strong> karena <strong>{{ $ppReg->keterangan }}</strong>.
</p>

<p>
	Silahkan kunjungi <a href="{{ $login = url('login') }}">{{ $login }}</a> untuk melakukan revisi.
</p>

<p>
	Jika Anda membutuhkan informasi yang lebih detail, silahkan hubungi {{ $ppReg->nama($ppReg->npk_reject) }} ({{ $ppReg->npk_reject }}).
</p>

<p>
	Terima Kasih.
</p>

<p>
	<strong>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel').' TRIAL' }}</strong>
</p>