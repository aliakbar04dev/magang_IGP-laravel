<p>
	{{ salam() }},
</p>

@if (strtoupper($kpd) !== 'USER')
<p>
	Kepada: <strong>{{ $kpd }} Daftar Masalah</strong>
</p>
@else
<p>
	Kepada: <strong>{{  $mtctdftmslh->nama($mtctdftmslh->creaby) }} ({{ $mtctdftmslh->creaby }})</strong>
</p>
@endif

<p>
	Telah disetujui Daftar Masalah dengan No: <strong>{{ $mtctdftmslh->no_dm }}</strong> oleh {{ $oleh }}: <strong>{{ Auth::user()->name }} ({{ Auth::user()->username }})</strong> dengan detail sebagai berikut:
</p>

<p>
	- Tgl DM: {{ \Carbon\Carbon::parse($mtctdftmslh->tgl_dm)->format('d/m/Y') }}.<br>
	- Site: {{ $mtctdftmslh->kd_site }}.<br>
	- Plant: {{ $mtctdftmslh->kd_plant }}.<br>
	- Line: {{ $mtctdftmslh->kd_line }} - {{ $mtctdftmslh->nm_line }}.<br>
	- Mesin: {{ $mtctdftmslh->kd_mesin }} - {{ $mtctdftmslh->nm_mesin }}.<br>
	- Problem: {{ $mtctdftmslh->ket_prob }}.<br>
	- Counter Measure: {{ $mtctdftmslh->ket_cm }}.<br>
	- Spare Part: {{ $mtctdftmslh->ket_sp }}.<br>
	- Evaluasi Hasil: {{ $mtctdftmslh->ket_eva_hasil }}.<br>
	- Remain: {{ $mtctdftmslh->ket_remain }}.<br>
	- Remark: {{ $mtctdftmslh->ket_remark }}.<br>
	@if (!empty($mtctdftmslh->tgl_plan_mulai))
	- Tgl Planning Pengerjaan: {{ \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('d/m/Y H:i') }} s/d {{ \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_selesai)->format('d/m/Y H:i') }}.<br>
	@else 
	- Tgl Planning Pengerjaan: -.<br>
	@endif
</p>

@if (strtoupper($kpd) !== 'USER')
<p>
	Mohon Segera diproses.
</p>
@endif

<p>
	Untuk melihat lebih detail Daftar Masalah tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
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