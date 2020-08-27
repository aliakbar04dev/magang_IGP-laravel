<p>
	{{ salam() }},
</p>

<p>
	Kepada: <strong>{{ $nm_kpd }} ({{ $kpd }})</strong>
</p>

<p>
	Telah ditolak PO dengan No: <strong>{{ $baanpo1->no_po }}</strong> Revisi: <strong>{{ $baanpo1->no_revisi }}</strong> oleh <strong>{{ $oleh }}</strong>: <strong>{{ $nm_oleh }}</strong>.
</p>

<p>
	Untuk info lebih lanjut, silahkan hubungi {{ $oleh }} tsb.
</p>

@if (strtoupper($kpd) !== 'PIC')
<p>
	Untuk melihat detail PO tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a> atau download melalui link <a href="{{ route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)]) }}">Download File PO</a>.
</p>
@else
<p>
	Untuk melihat detail PO tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
</p>
@endif

<p>
	Terima kasih atas perhatian dan kerjasamanya.
</p>

<p>
	Salam,<br><br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }}) ({{ Auth::user()->email }})<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>

<p>
	********************************************************************************************************<br>
	<strong>Note: Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>