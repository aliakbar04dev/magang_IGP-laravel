<p>
	{{ salam() }},
</p>

<p>
	Kepada: Bapak/Ibu <strong>{{ $hrdtidpdep1->namaByNpk($hrdtidpdep1->npk_div_head) }}</strong>
</p>

<p>
	Telah disetujui Individual Development Plan Department Head oleh HRD: {{ Auth::user()->name }} ({{ Auth::user()->username }}) pada tanggal {{ \Carbon\Carbon::now()->format('d M Y H:i') }} dengan detail sebagai berikut:
</p>

<p>
	- Tahun: {{ $hrdtidpdep1->tahun }}.<br>
	- Revisi: {{ $hrdtidpdep1->revisi }}.<br>
	- NPK / Nama: {{ $hrdtidpdep1->npk }} / {{ $hrdtidpdep1->namaByNpk($hrdtidpdep1->npk) }}.<br>
	- Divisi / Department: {{ $hrdtidpdep1->kd_div." - ".$hrdtidpdep1->namaDivisi($hrdtidpdep1->kd_div) }} / {{ $hrdtidpdep1->kd_dep." - ".$hrdtidpdep1->namaDepartemen($hrdtidpdep1->kd_dep) }}.<br>
	- Status: {{ $hrdtidpdep1->status }}.
</p>

<p>
	Untuk melihat lebih detail IDP tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
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