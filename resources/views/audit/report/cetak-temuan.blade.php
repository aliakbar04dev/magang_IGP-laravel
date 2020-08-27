<html>
<head>
   
    <title>PRINT TEMUAN AUDIT</title>
     <style>
@page { size: A4 }
 
    h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }
 
    table {
        border-collapse: collapse;
        width: 100%;
    }
 
    .table th {
        padding: 8px 8px;
        border:1px solid #000000;
        text-align: center;
    }
 
    .table td {
        padding: 3px 3px;
        border:1px solid #000000;
    }
 
    .text-center {
        text-align: center;
    }

    body { 
        font-family: 'Times New Roman', Times, serif;
    }
</style>

</head>
    <body>            
        <table class="table table-bordered">
            <tr>
                <td style="width:120px;border-bottom: double;text-align: center;"><img style="width: 100px;" src="{{ asset('images/logo.png') }}"></td>
                <td colspan="9" style="text-align: center;font-size: 20px;border-bottom: double;">AUDIT WORKSHEET</td>
            </tr>
            <tr>
                <td colspan="2" style="width:150px;">Finding Number</td>    
                <td colspan="4" style="text-align: center;">{{ $get_temuan->finding_no }}</td>
                <td>Date / Shift</td>
                <td colspan="3" style="text-align: center;">{{ date("d M y", strtotime($get_temuan->tanggal)) }} / {{ $get_temuan->shift }}</td>
            </tr>
            <tr>
                <td colspan="2">Area/Process/Line</td>
                <td colspan="4">{{ $get_temuan->line }} / {{ $get_temuan->process }}</td>
                <td>Category</td>
                <td colspan="3">{{ $get_temuan->cat }}</td>
            </tr>
            <tr>
                <td colspan="2">Auditee</td>
                <td colspan="4">@foreach($get_audteetor as $auditee) @if($auditee->status == 'Auditee'){{$auditee->nama}},@endif @endforeach</td>
                <td>Auditor</td>
                <td colspan="3">@foreach($get_audteetor as $auditor) @if($auditor->status == 'Auditor'){{$auditor->nama}},@endif @endforeach</td>
            </tr>
            <tr>
                <td colspan="10" style="vertical-align: top;"><u><b>Statement of NC</b></u><br><br> {!! str_replace("\n","<br>", $get_temuan->statement_of_nc) !!}</td>
            </tr>
            <tr>
                <td rowspan="4">REFF / STD</td>
                <td style="white-space:nowrap;">QMS DOC</td>
                <td colspan="8">{{ $get_temuan->qms_doc_ref }}</td>
            </tr>
            <tr>
                <td style="width: 60px;white-space:nowrap;">IATF 16949</td>
                <td colspan="8">{{ $get_temuan->iatf_ref }}</td>
            </tr>
            <tr>
                <td style="white-space:nowrap;">ISO 9001</td>
                <td colspan="8">{{ $get_temuan->iso_ref }}</td>
            </tr>
            <tr>
                <td style="white-space:nowrap;">CSR</td>
                <td colspan="8">{{ $get_temuan->csr }}</td>
            </tr>
            <tr>
                <td colspan="10" style="vertical-align: top;"><u><b>Detail of Problem and Evidence</b></u><br><br>{!! str_replace("\n","<br>", $get_temuan->detail_problem) !!}</td>
            </tr>
            @foreach ($get_containment as $coa)
            <tr>
                <td colspan="7" style="vertical-align: top;"><b>Containment of Action</b></td>
                <td colspan="2" style="vertical-align: top;"><b>PIC</b></td>
                <td colspan="1" style="vertical-align: top;font-size: 12px;"><b>DUE DATE</b></td>
            </tr>
            <tr>
                <td colspan="7" style="vertical-align: top;"><br>{!! str_replace("\n","<br>", $coa->containment_of_action) !!}</td>
                @php 
                $nama = DB::table('v_mas_karyawan')
                ->select('nama')
                ->where('npk', '=', $coa->pic)
                ->get();
                @endphp
                <td style="vertical-align: top;" colspan="2"><br>{{ $nama->first()->nama }}</td>
                <td style="vertical-align: top;white-space:nowrap" colspan="1"><br>{{ date("d M y", strtotime($coa->due_date)) }}</td>
            </tr>
            <tr>
                <td colspan="7" style="vertical-align: top;"><b>Root Cause & Corrective Action must be submit at <small>(date)</small></small></b></td>
                <td style="text-align: center;white-space:nowrap" colspan="3">{{ date("d M y", strtotime($coa->target_date)) }}</td>
            </tr>
            @endforeach
            <tr>
                <td rowspan="3" colspan="6" style="height: 70px;vertical-align: top;"><b>Remark</b></td>
                <td colspan="2"><b>Auditee Sign</b></td>
                <td colspan="2"><b>Auditor Sign</b></td>
            </tr>
            <tr>
                <td rowspan="2" colspan="2">{{ $nama_auditee }}</td>
                <td rowspan="2"colspan="2">{{ $nama_auditor }}</td>
            </tr>
            <tr>

            </tr>
        </table>
    </body>
</html>