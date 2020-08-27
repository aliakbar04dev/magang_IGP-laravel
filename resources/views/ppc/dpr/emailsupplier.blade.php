<p>
	{{ salamEng() }},
</p>

<p>
	To: <strong>{{ $ppctdpr->namaSupp($ppctdpr->kd_bpid) }} ({{ $ppctdpr->kd_bpid }})</strong>
</p>

<p>
	Herewith, we inform Delivery Problem Report No.: <strong>{{ $ppctdpr->no_dpr }}</strong><br>
	Please submit Planning Improvement & Corrective Action (PICA) before <strong><u>{{ \Carbon\Carbon::now()->addDays(7)->format('F, d, Y') }}</u></strong>.
</p>

<p>
	For detail problem can be access to <a href="{{ $login = str_replace('iaess','vendor', url('login')) }}">{{ str_replace('iaess','vendor', $login) }}</a>.
</p>

<p>
	Best Regards,<br><br>
	{{ Auth::user()->name }} ({{ Auth::user()->username }})<br>
	<strong><u><font color="red">{{ strtoupper(config('app.nm_pt', 'Laravel')) }}</font></u></strong><br>
	Production Planning & Control<br>
	Material Planning Team<br>
	mail: <a href="mailto:matplan@igp-astra.co.id">matplan@igp-astra.co.id</a>
</p>

<p>
	*** <strong><u><i><font color="blue">This mail is sent by system, please not to reply this mail</font></i></u></strong> ***
</p>