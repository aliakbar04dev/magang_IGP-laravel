

<!-- <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#detailModal{{ $get_temuans->id }}"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></a> -->
<a class="btn btn-primary btn-sm" href="{{ route('auditors.daftartemuanByNo', $get_temuans->id) }}" target="_blank">DETAIL</a>
    
    @if ($get_list->count() == 0)
        <button class="btn btn-success btn-sm" id="{{ $get_temuans->id }}" onclick="select(this.id)">PILIH</button>
    @endif
<!-- <div class="modal fade" id="detailModal{{ $get_temuans->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    {{-- <div class="modal-dialog" style="width:800px"> --}}
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="detailModalLabel">Popup</h4>
            </div>
            <div class="modal-body">
               <table class="table tabledetail" style="border: 1px solid black;">
            <tr>
                <td style="width:120px;border-bottom: double;text-align: center;"><img style="width: 100px;" src="{{ asset('images/logo.png') }}"></td>
                <td colspan="9" style="text-align: center;font-size: 20px;border-bottom: double;">AUDIT WORKSHEET</td>
            </tr>
            <tr>
                <td colspan="2" style="width:150px;">Finding Number</td>    
                <td colspan="4" style="text-align: center;">{{ $get_temuans->finding_no }}</td>
                <td>Date / Shift</td>
                <td colspan="3" style="text-align: center;">{{ date("d M y", strtotime($get_temuans->tanggal)) }} / {{ $get_temuans->shift }}</td>
            </tr>
            <tr>
                <td colspan="2">Area/Process/Line</td>
                <td colspan="4">{{ $get_temuans->line }} / {{ $get_temuans->process }}</td>
                <td>Category</td>
                <td colspan="3">{{ $get_temuans->cat }}</td>
            </tr>
            <tr>
                <td colspan="2">Auditee</td>
                <td colspan="4">@foreach($get_audteetor as $auditee) @if($auditee->status == 'Auditee'){{$auditee->nama}},@endif @endforeach</td>
                <td>Auditor</td>
                <td colspan="3">@foreach($get_audteetor as $auditor) @if($auditor->status == 'Auditor'){{$auditor->nama}},@endif @endforeach</td>
            </tr>
            <tr>
                <td colspan="10" style="height: 150px;vertical-align: top;"><u><b>Statement of NC</b></u><br><br> {!! str_replace("\n","<br>", $get_temuans->statement_of_nc) !!}</td>
            </tr>
            <tr>
                <td rowspan="4">REFF / STD</td>
                <td>QMS DOC</td>
                <td colspan="8">{{ $get_temuans->qms_doc_ref }}</td>
            </tr>
            <tr>
                <td style="width: 60px;">IATF 16949</td>
                <td colspan="8">{{ $get_temuans->iatf_ref }}</td>
            </tr>
            <tr>
                <td>ISO 9001</td>
                <td colspan="8">{{ $get_temuans->iso_ref }}</td>
            </tr>
            <tr>
                <td>CSR</td>
                <td colspan="8">{{ $get_temuans->csr }}</td>
            </tr>
            <tr>
                <td colspan="10" style="height: 250px;vertical-align: top;"><u><b>Detail of Problem and Evidence</b></u><br><br>{!! str_replace("\n","<br>", $get_temuans->detail_problem) !!}</td>
            </tr>
            @foreach ($get_containment as $coa)
            <tr>
                <td colspan="7" style="vertical-align: top;"><b>Containment of Action</b></td>
                <td colspan="2" style="vertical-align: top;"><b>PIC</b></td>
                <td colspan="1" style="vertical-align: top;font-size: 12px;"><b>DUE DATE</b></td>
            </tr>
            <tr>
                <td colspan="7" style="vertical-align: top;"><br>{!! str_replace("\n","<br>", $coa->containment_of_action) !!}</td>
                <td style="vertical-align: top;" colspan="2"><br>{{ $coa->pic }}</td>
                <td style="vertical-align: top;" colspan="1"><br>{{ date("d M y", strtotime($coa->due_date)) }}</td>
            </tr>
            <tr>
                <td colspan="7" style="vertical-align: top;"><b>Root Cause & Corrective Action must be submit at <small>(date)</small></small></b></td>
                <td style="text-align: center;" colspan="3">{{ date("d M y", strtotime($coa->target_date)) }}</td>
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
            </div>
        </div>
    </div>
</div> -->