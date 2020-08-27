<p>
	{{ salam() }},
</p>

<p>
	Kepada Yang Terhormat, <br>
	<strong>{{ $nm_kpd }} ({{ $kpd }})</strong>
</p>

@if ($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl != null && $baanpo1->apr_dep_tgl != null && $baanpo1->apr_div_tgl != null)
<p>
	Dengan ini kami kirimkan PO No: <strong>{{ $baanpo1->no_po }}</strong> Revisi: <strong>{{ $baanpo1->no_revisi }}</strong> yang <strong>SUDAH LENGKAP DITANDATANGANI</strong>, 
</p>

<p>
	<strong>ADAPUN PO INI BISA DIGUNAKAN SEBAGAI DASAR PENAGIHAN SUPPLIER</strong> dan mengenai waktu pengiriman, mohon disesuaikan dengan schedule yang disampaikan oleh pihak IGP.
</p>

<p>
	Untuk melihat detail PO tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ str_replace('iaess','vendor',$login) }}</a> atau download melalui link <a href="{{ str_replace('iaess','vendor',route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])) }}">Download File PO</a>.
</p>

<p>
	Demikian kami sampaikan dan atas perhatian serta kerjasamanya kami sampaikan terima kasih.
</p>

<p>
	Hormat kami, <br><br>
	{{ Auth::user()->namaByNpk($baanpo1->apr_pic_npk) }} ({{ $baanpo1->apr_pic_npk }}) ({{ Auth::user()->emailByUsername($baanpo1->apr_pic_npk) }})<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>
@else
<p>
	Berikut kami informasikan <strong>DRAFT PO</strong> No: <strong>{{ $baanpo1->no_po }}</strong> Revisi: <strong>{{ $baanpo1->no_revisi }}</strong>, <br>
	dengan catatan sebagai berikut: 
</p>

<p>
	<ol>
		<li>Waktu pengiriman disesuaikan dengan schedule yang diinformasikan oleh pihak IGP.</li> 
		<li>Draft PO terlampir tidak bisa digunakan untuk transaksi penagihan.</li> 
		<li>No PO yang disampaikan bisa digunakan pada surat jalan supplier.</li> 
	</ol> 
</p>

<p>
	Untuk melihat detail PO tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ str_replace('iaess','vendor',$login) }}</a> atau download melalui link <a href="{{ str_replace('iaess','vendor',route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])) }}">Download File PO</a>.
</p>

<p>
	Demikian <strong>DRAFT PO</strong> ini kami sampaikan, apabila terdapat hal yang perlu ditanyakan, silahkan menghubungi kami.
</p>

<p>
	Terima kasih, <br><br>
	{{ Auth::user()->namaByNpk($baanpo1->apr_pic_npk) }} ({{ $baanpo1->apr_pic_npk }}) ({{ Auth::user()->emailByUsername($baanpo1->apr_pic_npk) }})<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>
@endif

<p>
	********************************************************************************************************<br>
	<strong>Note:<br>
	-Jika ada perubahan akan kami informasikan lebih lanjut.<br>
	-Mohon untuk tidak membalas email ini, karena email ini dikirim dari Aplikasi.</strong><br>
	********************************************************************************************************
</p>