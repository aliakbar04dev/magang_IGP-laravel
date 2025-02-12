<p>
	{{ salamEng() }},
</p>

<p>
	Dear Supplier, <br>
	<strong>{{ $nm_kpd }} ({{ $kpd }})</strong>
</p>

@if ($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl != null && $baanpo1->apr_dep_tgl != null && $baanpo1->apr_div_tgl != null)
<p>
	Herewith we would like to send PO Number: <strong>{{ $baanpo1->no_po }}</strong> Rev: <strong>{{ $baanpo1->no_revisi }}</strong> that already full approval.
</p>

<p>
	This PO can be used for invoicing. For delivery time, please use delivery schedule from IGP.
</p>

<p>
	For detailed PO, please login to <a href="{{ $login = str_replace('iaess','vendor', url('login')) }}">{{ str_replace('iaess','vendor', $login) }}</a> or you can download using following link <a href="{{ str_replace('iaess','vendor', route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])) }}">Download File PO</a>.
</p>

<p>
	Thank you for your attention.
</p>

<p>
	Thank you, <br><br>
	{{ Auth::user()->namaByNpk($baanpo1->apr_pic_npk) }} ({{ $baanpo1->apr_pic_npk }}) ({{ Auth::user()->emailByUsername($baanpo1->apr_pic_npk) }})<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>
@else
<p>
	Herewith we would like to send <strong>DRAFT PO</strong> Number: <strong>{{ $baanpo1->no_po }}</strong> Rev: <strong>{{ $baanpo1->no_revisi }}</strong>, <br>
	with following information: 
</p>

<p>
	<ol>
		<li>For delivery time, please use delivery schedule from IGP.</li> 
		<li>This PO cannot be used for invoicing.</li> 
		<li>PO number can be used for delivery slip and delivery note.</li> 
	</ol> 
</p>

<p>
	For detailed PO, please login to <a href="{{ $login = str_replace('iaess','vendor', url('login')) }}">{{ str_replace('iaess','vendor', $login) }}</a> or you can download using following link <a href="{{ str_replace('iaess','vendor', route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])) }}">Download File PO</a>.
</p>

<p>
	If there is any queries, please don’t hesitate to contact us.
</p>

<p>
	Thank you, <br><br>
	{{ Auth::user()->namaByNpk($baanpo1->apr_pic_npk) }} ({{ $baanpo1->apr_pic_npk }}) ({{ Auth::user()->emailByUsername($baanpo1->apr_pic_npk) }})<br>
	{{ strtoupper(config('app.nm_pt', 'Laravel')) }}
</p>
@endif

<p>
	********************************************************************************************************<br>
	<strong>Note:<br>
	-If there is any changing, we will inform you soon.<br>
	-Please don’t reply this e-mail.</strong><br>
	********************************************************************************************************
</p>