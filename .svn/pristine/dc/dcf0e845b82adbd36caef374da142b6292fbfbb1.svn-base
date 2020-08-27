<p>
	{{ salam() }},
</p>

<p>
	Kepada: <strong>{{  $mtctlogpkb->nm_creaby }} ({{ $mtctlogpkb->creaby }})</strong>
</p>

<p>
	Telah disetujui Kebutuhan Spare Parts Plant Tanggal: <strong>{{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') }}</strong> oleh: <strong>{{ Auth::user()->name }} ({{ Auth::user()->username }})</strong> dengan detail sebagai berikut:
</p>

<p>
	- Tanggal: {{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') }}.<br>
	- Pembuat: {{ $mtctlogpkb->creaby }} - {{  $mtctlogpkb->nm_creaby }}.<br>
	- Plant: {{ $mtctlogpkb->kd_plant }}.<br>
	- Item: {{ $mtctlogpkb->kd_item }} - {{ $mtctlogpkb->nm_item }}.<br>
	- Nama Barang: {{ $mtctlogpkb->nm_brg }}.<br>
	- Nama Type: {{ $mtctlogpkb->nm_type }}.<br>
	- Nama Merk: {{ $mtctlogpkb->nm_merk }}.<br>
	- QTY: {{ numberFormatter(0, 2)->format($mtctlogpkb->qty) }}.<br>
	- Satuan: {{ $mtctlogpkb->kd_sat }}.<br>
	- Keterangan: {{ $mtctlogpkb->ket_mesin_line }}.<br>
	- Dok. Ref: {{ $mtctlogpkb->dok_ref_ket }}.<br>
	- No. Referensi: {{ $mtctlogpkb->no_dok }}.
</p>

<p>
	Untuk melihat lebih detail Kebutuhan Spare Parts Plant tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
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