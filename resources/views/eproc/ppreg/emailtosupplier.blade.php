<p>
	{{ salam() }},
</p>

<p>
	Kepada: <strong>{{ $ppReg->namaSupp($ppReg->kd_supp) }}</strong>
</p>

<p>
	Berikut Informasi mengenai permintaan barang dari bagian {{ $ppReg->nm_dept }} ({{ $ppReg->kd_dept_pembuat }}), tolong untuk segera mengirimkannya.<br>
	<strong>Saat pengiriman mohon untuk mencantumkan nomor ini {{ $ppReg->no_reg }}.</strong>
</p>

<p>
	Berikut detail barang:<br>
	@foreach ($ppReg->ppRegDetails()->get() as $ppRegDetail)
	{{ $loop->iteration }}. {{ $ppRegDetail->nm_brg != null ? $ppRegDetail->nm_brg : $ppRegDetail->desc }} = {{ $ppRegDetail->qty_pp }}<br>
	@endforeach
</p>

<p>
	Untuk lebih detailnya dapat lihat di attachment.
</p>

<p>
	Terima Kasih.
</p>

<p>
	PRC - {{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>