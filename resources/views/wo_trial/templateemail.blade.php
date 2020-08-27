<p>
    {{ salam() }},
</p>

<p>
    Ada WO : <strong>{{ $no_wo }}</strong> .
</p>

<p>
    Tgl Permintaan WO : <strong>{{ date('d-m-Y', strtotime($tgl_wo)) }}</strong> .
</p>

<p>
    Dari User : <strong>{{ $bagian }}</strong> - <strong>{{ $kodepabrik }}</strong> .
</p>

<p>
    Dengan Permintaan : <strong>{{ $ket_wo }}</strong> . 
</p>