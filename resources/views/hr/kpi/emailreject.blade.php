<p>
	{{ salam() }},
</p>

<p>
	Kepada: Bapak/Ibu <strong>{{ $hrdtkpi->namaByNpk($hrdtkpi->npk) }}</strong>
</p>

<p>
	Mohon maaf, KPI Division {{ $hrdtkpi->desc_div }} telah ditolak oleh: {{ Auth::user()->name }} ({{ Auth::user()->username }}) pada tanggal {{ \Carbon\Carbon::now()->format('d M Y H:i') }} dengan detail sebagai berikut:
</p>

<p>
	- Tahun: {{ $hrdtkpi->tahun }}.<br>
	- Revisi: {{ $hrdtkpi->revisi }}.<br>
	- NPK / Nama: {{ $hrdtkpi->npk }} / {{ $hrdtkpi->namaByNpk($hrdtkpi->npk) }}.<br>
	- Divisi: {{ $hrdtkpi->kd_div." - ".$hrdtkpi->desc_div }}.<br>
	- Superior: {{ $hrdtkpi->npk_atasan }} / {{ $hrdtkpi->namaByNpk($hrdtkpi->npk_atasan) }}.<br>
	- Status: {{ $hrdtkpi->status }}.<br>
	- Alasan: {{ $alasan }}.
</p>

<p>
	Untuk melihat lebih detail KPI Division tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
</p>

<p>
	Terima kasih atas perhatian dan kerjasamanya.
</p>

<p>
	Salam,<br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }}) ({{ Auth::user()->email }})
</p>

<p>
	********************************************************************************************************<br>
	<strong>Note: Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>