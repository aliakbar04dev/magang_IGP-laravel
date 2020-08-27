<p>
	{{ salam() }},
</p>

@if (strtoupper($mode) === 'SH_1' || strtoupper($mode) === 'SH_2' || strtoupper($mode) === 'SH_3')
<p>
	Kepada: <strong>SECTION HEAD</strong>
</p>

<p>
	Berikut Informasi mengenai QPR dengan No: <strong>{{ $qpr->issue_no }}</strong>
</p>

<p>
	Mohon Segera diproses.
</p>
@elseif (strtoupper($mode) === 'SH' || strtoupper($mode) === '1' || strtoupper($mode) === '2' || strtoupper($mode) === '3')
<p>
	Kepada: <strong>{{ $qpr->namaSupp($qpr->kd_supp) }} ({{ $qpr->kd_supp }})</strong>
</p>

<p>
	Berikut Informasi mengenai QPR dengan No: <strong>{{ $qpr->issue_no }}</strong>
</p>

<p>
	Mohon Segera diproses.
</p>
@elseif (strtoupper($mode) === 'SH2')
<p>
	Kepada: <strong>QC {{ strtoupper(config('app.nm_pt', 'Laravel')) }}</strong>
</p>

<p>
	Telah diajukan Complain untuk QPR dengan No: <strong>{{ $qpr->issue_no }}</strong> oleh <strong>Supplier</strong>: <strong>{{ $qpr->portal_pic_reject }}</strong> karena <strong>{{ $qpr->status_reject }} - {{ $qpr->portal_ket_reject }}</strong>.
</p>

<p>
	Complain telah disetujui oleh <strong>Section Head</strong>: <strong>{{ Auth::user()->name }} ({{ Auth::user()->username }})</strong>.
</p>

<p>
	Silahkan menggunakan aplikasi <strong>IG-Pro</strong> untuk melakukan revisi.
</p>
@else
<p>
	Kepada: <strong>QC {{ strtoupper(config('app.nm_pt', 'Laravel')) }}</strong>
</p>

<p>
	Telah disetujui QPR dengan No: <strong>{{ $qpr->issue_no }}</strong> oleh <strong>Supplier</strong>: <strong>{{ $qpr->portal_pic_terima }}</strong>.
</p>
@endif

@if(!empty($qpr->portal_pict))
<p>
	Untuk melihat detail QPR tsb silahkan masuk ke <a href="{{ $login = str_replace('iaess','vendor', url('login')) }}">{{ str_replace('iaess','vendor', $login) }}</a> atau download melalui link <a href="{{ str_replace('iaess','vendor', route('qprs.downloadqpr', [base64_encode($qpr->kd_supp), base64_encode($qpr->issue_no)])) }}">Download File QPR</a>.
</p>
@else
<p>
	Untuk melihat detail QPR tsb silahkan masuk ke <a href="{{ $login = str_replace('iaess','vendor', url('login')) }}">{{ str_replace('iaess','vendor', $login) }}</a>.
</p>
@endif

<p>
	Terima kasih atas perhatian dan kerjasamanya.
</p>

@if (strtoupper($mode) === 'SH')
<p>
	Salam,<br><br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }})<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>
@elseif (strtoupper($mode) === 'SH2')
<p>
	Salam,<br><br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }})<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>
@elseif (strtoupper($mode) === 'SP')
<p>
	Salam,<br><br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }}) ({{ Auth::user()->nm_supp }})
</p>
@else
<p>
	Salam,<br><br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>
@endif

<p>
	********************************************************************************************************<br>
	<strong>Note: Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>