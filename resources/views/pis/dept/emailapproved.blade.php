<p>
	{{ salam() }},
</p>

<p>
	Telah disetujui PIS dengan No: <strong>{{ $pis}}</strong> oleh PT. INTI GANDA PERDANA.
</p>

<p>
	<strong>Note: {{ $catatan}}.</strong>
</p>

<p>
	Terima kasih atas perhatian dan kerjasamanya.
</p>

<p>
	Salam,<br><br>
	{{ Auth::user()->name }}
</p>

<p>
	********************************************************************************************************<br>
	<strong>Note: Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>