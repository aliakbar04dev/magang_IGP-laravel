<p>
	{{ salam() }},
</p>

<p>
	Kepada: <strong>{{  $mtctdftmslh->nama($mtctdftmslh->creaby) }} ({{ $mtctdftmslh->creaby }})</strong>
</p>

<p>
	Telah dihapus Daftar Masalah dengan No: <strong>{{ $mtctdftmslh->no_dm }}</strong> oleh PIC: <strong>{{ Auth::user()->name }} ({{ Auth::user()->username }})</strong> dengan detail sebagai berikut:
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
	@endif
</p>

<p>
	Untuk info lebih lanjut, silahkan hubungi PIC tsb.
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