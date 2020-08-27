<p>
	{{ salam() }},
</p>

<p>
	Kepada: <strong>{{ $ehstwp1->kd_supp }} ({{ $ehstwp1->namaSupp($ehstwp1->kd_supp) }})</strong>
</p>

<p>
	Telah ditolak Ijin Kerja dengan No: <strong>{{ $ehstwp1->no_wp }}</strong> oleh {{ $oleh }}: <strong>{{ Auth::user()->name }} ({{ Auth::user()->username }})</strong> dengan detail sebagai berikut:
</p>

<p>
	- Supplier: {{ $ehstwp1->kd_supp }} ({{ $ehstwp1->namaSupp($ehstwp1->kd_supp) }}).<br>
	- Tgl Ijin Kerja: {{ \Carbon\Carbon::parse($ehstwp1->tgl_wp)->format('d/m/Y') }}.<br>
	- Project: {{ $ehstwp1->nm_proyek }}.<br>
	- Lokasi: {{ $ehstwp1->lok_proyek }}.<br>
	- Site: {{ $ehstwp1->kd_site }} ({{ $ehstwp1->nm_site }}).<br>
	- PIC: {{ $ehstwp1->pic_pp }} ({{ $ehstwp1->nm_pic }}).<br>
	@if (!empty($ehstwp1->approve_ehs_tgl))
	- Jenis Pekerjaan: {{ $ehstwp1->jns_pekerjaan_desc }}.<br>
	@endif
	- Keterangan Reject: <strong>{{ $keterangan }}.</strong><br>
</p>

<p>
	Untuk info lebih lanjut, silahkan hubungi {{ $oleh }} tsb.
</p>

<p>
	Untuk melihat lebih detail Ijin Kerja tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
</p>

<p>
	Terima kasih atas perhatian dan kerjasamanya.
</p>

<p>
	Salam,<br><br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }})<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>

<p>
	********************************************************************************************************<br>
	<strong>Note: Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>