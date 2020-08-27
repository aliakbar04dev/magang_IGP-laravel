<p>
	{{ salam() }},
</p>

<p>
	Kepada: Bapak/Ibu <strong>Staff HRD</strong>
</p>

<p>
	Telah disetujui Individual Development Plan Section Head oleh Div Head: {{ Auth::user()->name }} ({{ Auth::user()->username }}) pada tanggal {{ \Carbon\Carbon::now()->format('d M Y H:i') }} dengan detail sebagai berikut:
</p>

<p>
	- Tahun: {{ $hrdtidp1->tahun }}.<br>
	- Revisi: {{ $hrdtidp1->revisi }}.<br>
	- NPK / Nama: {{ $hrdtidp1->npk }} / {{ $hrdtidp1->namaByNpk($hrdtidp1->npk) }}.<br>
	- Divisi / Department: {{ $hrdtidp1->kd_div." - ".$hrdtidp1->namaDivisi($hrdtidp1->kd_div) }} / {{ $hrdtidp1->kd_dep." - ".$hrdtidp1->namaDepartemen($hrdtidp1->kd_dep) }}.<br>
	- Status: {{ $hrdtidp1->status }}.
</p>

<p>
	Mohon untuk segera ditindaklanjuti.
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