<p>
	{{ salam() }},
</p>

<p>
	Kepada: <strong>Team Budget and Corporate Control</strong>
</p>

<p>
	Telah di-submit Pengajuan Komite Investasi dengan No: <strong>{{ $bgttkomite1->no_komite }}</strong>, No. Revisi: <strong>{{ $bgttkomite1->no_rev }}</strong> oleh: <strong>{{ Auth::user()->name }} ({{ Auth::user()->username }})</strong> dengan detail sebagai berikut:
</p>

<p>
	- Tgl Pengajuan: {{ \Carbon\Carbon::parse($bgttkomite1->tgl_pengajuan)->format('d/m/Y') }}.<br>
	- Presenter: {{ $bgttkomite1->npk_presenter }} - {{ $bgttkomite1->nm_presenter }}.<br>
	- Departemen: {{ $bgttkomite1->kd_dept }} - {{ $bgttkomite1->namaDepartemen($bgttkomite1->kd_dept) }}.<br>
	- Topik: {{ $bgttkomite1->topik }}.<br>
	- Jenis Komite: {{ $bgttkomite1->jns_komite }}.<br>
	- No. IA/EA: {{ $bgttkomite1->no_ie_ea }}.<br>
	- Catatan: {{ $bgttkomite1->catatan }}.<br>
</p>

<p>
	Mohon Segera diproses.
</p>

<p>
	Untuk melihat lebih detail Pengajuan Komite Investasi tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
</p>

<p>
	Terima kasih atas perhatian dan kerjasamanya.
</p>

<p>
	Salam,<br><br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }})
</p>

<p>
	********************************************************************************************************<br>
	<strong>Note: Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>