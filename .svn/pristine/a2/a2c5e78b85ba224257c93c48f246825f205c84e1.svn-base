<p>
	{{ salam() }},
</p>

<p>
	Kepada: <strong>{{  $tmtcwo1->nama($tmtcwo1->creaby) }} ({{ $tmtcwo1->creaby }})</strong>
</p>

<p>
	Telah ditolak Laporan Pekerjaan dengan No: <strong>{{ $tmtcwo1->no_wo }}</strong> oleh {{ $oleh }}: <strong>{{ Auth::user()->name }} ({{ Auth::user()->username }})</strong> dengan detail sebagai berikut:
</p>

<p>
	- Tgl WO: {{ \Carbon\Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y') }}.<br>
	- Info Kerja: {{ $tmtcwo1->info_kerja }}.<br>
	- Site: {{ $tmtcwo1->kd_site }}.<br>
	- Plant: {{ $tmtcwo1->lok_pt }}.<br>
	- Shift: {{ $tmtcwo1->shift }}.<br>
	- Line: {{ $tmtcwo1->kd_line }} - {{ $tmtcwo1->nm_line }}.<br>
	- Mesin: {{ $tmtcwo1->kd_mesin }} - {{ $tmtcwo1->nm_mesin }}.<br>
	- Problem: {{ $tmtcwo1->uraian_prob }}.<br>
	- Penyebab: {{ $tmtcwo1->uraian_penyebab }}.<br>
	- Langkah Kerja: {{ $tmtcwo1->langkah_kerja }}.<br>
	- Est.Pengerjaan (Mulai): {{ \Carbon\Carbon::parse($tmtcwo1->est_jamstart)->format('d/m/Y H:i:s') }}.<br>
	- Est.Pengerjaan (Selesai): {{ \Carbon\Carbon::parse($tmtcwo1->est_jamend)->format('d/m/Y H:i:s') }}.<br>
	- Jumlah Menit: {{ numberFormatter(0, 2)->format($tmtcwo1->est_durasi) }}.<br>
	- Line Stop (Menit): {{ numberFormatter(0, 2)->format($tmtcwo1->line_stop) }}.<br>
	- Pelaksana: {{ $tmtcwo1->nm_pelaksana }}.<br>
	- Keterangan: {{ $tmtcwo1->catatan }}.<br>
	@if ($tmtcwo1->st_main_item === "T")
		- Main Item: YA.<br>
		- IC: {{ $tmtcwo1->no_ic }} - {{ $tmtcwo1->nm_ic }}.<br>
	@else 
		- Main Item: TIDAK.<br>
	@endif
	@if (!empty($tmtcwo1->no_lhp))
		- No. LHP: {{ $tmtcwo1->no_lhp }}.<br>
		- LS Mulai: {{ \Carbon\Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i') }}.<br>
	@endif
	- Keterangan Reject: <strong>{{ $tmtcwo1->rjt_st }} - {{ $tmtcwo1->rjt_ket }}.</strong>
</p>

<p>
	Untuk info lebih lanjut, silahkan hubungi {{ $oleh }} tsb.
</p>

<p>
	Untuk melihat lebih detail Laporan Pekerjaan tsb silahkan masuk ke <a href="{{ $login = url('login') }}">{{ $login }}</a>.
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