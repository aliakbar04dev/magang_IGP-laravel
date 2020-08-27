<p>
	{{ salam() }},
</p>

<p>
	Kepada: <strong>{{ $nama }}</strong>
</p>

<p>
	Berikut terdapat beberapa PO yang belum disetujui:
</p>

<p>
	<table class="table" border="1" cellspacing="0" width="80%">
		<thead>
          <tr>
            <th style="width: 3%;">No</th>
            <th style="width: 15%;">No PO</th>
            <th style="width: 7%;">Revisi</th>
            <th style="width: 10%;">Tgl PO</th>
            <th style="width: 10%;">Tgl Kirim</th>
            <th>Supplier</th>
          </tr>
        </thead>
        <tbody>
			@foreach($baan_po1s as $baan_po1) 
				<tr>
					<td style="text-align: center;">{{ $loop->iteration }}</td>
					<td style="text-align: center;">{{ $baan_po1->no_po }}</td>
					<td style="text-align: center;">{{ $baan_po1->no_revisi }}</td>
					<td style="text-align: center;">{{ \Carbon\Carbon::parse($baan_po1->tgl_po)->format('d/m/Y') }}</td>
					<td style="text-align: center;">{{ \Carbon\Carbon::parse($baan_po1->ddat)->format('d/m/Y') }}</td>
					<td style="text-align: left;">{{ $baan_po1->nm_supp }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</p>

<p>
	Mohon Segera diproses.
</p>

<p>
	Terima kasih atas perhatian dan kerjasamanya.
</p>

<p>
	Salam,<br><br>
	SYSTEM PORTAL<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>

<p>
	********************************************************************************************************<br>
	<strong>Note: Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>