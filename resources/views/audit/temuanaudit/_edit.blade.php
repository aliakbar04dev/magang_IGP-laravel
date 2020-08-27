<div class="col-md-6">
<label class="bubble">AREA AUDIT</label>
<div class="bubble-content">
    <div>
        {!! Form::label('plant', 'PLANT(*)') !!}
        <input class="form-control" id="plant" value="@if ($get_temuan->plant == 1)IGP-1
                        @elseif($get_temuan->plant == 2)IGP-2
                        @elseif($get_temuan->plant == 3)IGP-3
                        @elseif($get_temuan->plant == 4)IGP-4
                        @elseif($get_temuan->plant == A)KIM-A
                        @elseif($get_temuan->plant == B)KIM-B
                        @endif" readonly>
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('div', 'DIVISI(*)') !!}
        @foreach ($getdiv as $div)
            @if ($div->kd_div == $get_temuan->div)
            <input class="form-control" style="width:100%;" value="{{ $div->desc_div }}" readonly>
            @break
            @endif
        @endforeach
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('dept', 'DEPT(*)') !!}
            @foreach ($getdep as $dep)
            @if ($dep->kd_dep == $get_temuan->dep)
            <input class="form-control" style="width:100%;" value="{{ $dep->desc_dep }}" readonly>
                @endif
            @endforeach
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('sect', 'SEKSI(*)') !!}
            @foreach ($getsie as $sie)
            @if ($sie->kd_sie == $get_temuan->sie)
            <input class="form-control" style="width:100%;" value="{{ $sie->desc_sie }}" readonly>
            @endif
            @endforeach
        {!! $errors->first('kd_dep', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
            {!! Form::label('line', 'LINE') !!}
                @foreach ($getline as $line)
                    @if ($line->xkd_line == $get_temuan->line)
                     <input class="form-control" style="width:100%;" value="{{ $line->xnm_line }}" readonly>
                    @endif
                @endforeach
    </div>
    <div style="margin-top: 8px;">
            {!! Form::label('process', 'PROCESS') !!}
                @foreach ($getprocess as $process)
                @if ($process->xkd_proses == $get_temuan->process)
                <input class="form-control" style="width:100%;" value="{{ $process->xnama_proses }}" readonly>
                @endif
                @endforeach
    </div>
</div>
</div>

<div class="col-md-6">
<label class="bubble">DETAIL</label>
<div class="bubble-content">
    <div>
        {!! Form::label('finding_no', 'FINDING NO.') !!}
        {!! Form::text('finding_no', $get_temuan->finding_no, ['class'=>'form-control', 'placeholder' => 'Finding No.', 'required', 'readonly' => '']) !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('tgl', 'TANGGAL(*)') !!}
        {!! Form::date('tgl', $get_temuan->tanggal, ['class'=>'form-control','placeholder' => \Carbon\Carbon::now(), 'style' => 'padding-top: 0px;', 'readonly' => '']) !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('category', 'CATEGORY FINDING(*)') !!}
        <input class="form-control" value="{{ $get_temuan->cat }}" readonly>
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('type', 'AUDIT TYPE(*)') !!}
        <input class="form-control" value="{{ $get_temuan->a_type }}" readonly>
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('shift', 'SHIFT(*)') !!}
        <input class="form-control" value="{{ $get_temuan->shift }}" readonly>
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('periode', 'PERIODE(*)') !!}
        <input class="form-control" value="{{ $get_temuan->periode }}" readonly>
    </div>
</div>
</div>

<div class="col-md-6">
<label class="bubble">AUDITOR</label> <button type="button" onclick="clear_auditor()" id="clearauditor" class="btn btn-danger btn-xs">CLEAR</button>
    <div class="bubble-content">
    @php $no_auditor = 1; $no_auditee = 1; @endphp
    @foreach($get_audteetor as $auditor)
        @if ($auditor->status == 'Auditor')
            @php $npk_auditor[$no_auditor] = $auditor->npk; $no_auditor++; @endphp
        @else
            @php $npk_auditee[$no_auditee] = $auditor->npk; $no_auditee++; @endphp
        @endif
    @endforeach
    @php
        if  ($no_auditor == 2){
            $npk_auditor[2] = null;
            $npk_auditor[3] = null;
            $npk_auditor[4] = null;
        } else if ($no_auditor == 3) {
            $npk_auditor[3] = null;
            $npk_auditor[4] = null;
        } else if ($no_auditor == 4) {
            $npk_auditor[4] = null;
        }
        if  ($no_auditee == 2){
            $npk_auditee[2] = null;
            $npk_auditee[3] = null;
            $npk_auditee[4] = null;
        } else if ($no_auditee == 3) {
            $npk_auditee[3] = null;
            $npk_auditee[4] = null;
        } else if ($no_auditee == 4) {
            $npk_auditee[4] = null;
        }
    @endphp
        <table>
        <tr>
            <td><input placeholder="Auditor 1" autocomplete="off" style="background-color: #d0fdda;text-align: center;" onclick="popupKaryawanAuditor(this.id)" class="form-control" id="auditor1" role="LEAD AUDITOR" name="auditor[]" data-toggle="modal" data-target="#auditorModal" value="{{ $npk_auditor[1] }}" readonly></td>
            <td><input placeholder="Auditor 2" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawanAuditor(this.id)" class="form-control" id="auditor2" role="AUDITOR" name="auditor[]" data-toggle="modal" data-target="#auditorModal" value="{{ $npk_auditor[2] }}" readonly></td>
            <td><input placeholder="Auditor 3" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawanAuditor(this.id)" class="form-control" id="auditor3" role="AUDITOR" name="auditor[]" data-toggle="modal" data-target="#auditorModal" value="{{ $npk_auditor[3] }}" readonly></td>
            <td><input placeholder="Auditor 4" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawanAuditor(this.id)" class="form-control" id="auditor4" role="AUDITOR" name="auditor[]" data-toggle="modal" data-target="#auditorModal" value="{{ $npk_auditor[4] }}" readonly></td>
        </tr>
        <tr>
            <td colspan="4"><input placeholder="List Nama (otomatis)" autocomplete="off" id="listauditor" name="listauditee" class="form-control" value="@foreach($get_audteetor as $auditee) @if($auditee->status == 'Auditee') {{$auditee->nama}}, @endif @endforeach" readonly></td>
        </tr>
    </table>
        </div>
    </div>

    <div class="col-md-6">
    <label class="bubble">AUDITEE</label> <button type="button" onclick="clear_auditee()" id="clearauditee" class="btn btn-danger btn-xs">CLEAR</button>
    <div class="bubble-content" style="margin-top: -5px;">
        <table>
         <tr>
                <td><input placeholder="Auditee 1" autocomplete="off" style="background-color: #d0fdda;text-align: center;" onclick="popupKaryawan(this.id)" class="form-control" id="auditee1" name="auditee[]" data-toggle="modal" data-target="#karyawanModal" value="{{ $npk_auditee[1] }}" readonly></td>
                <td><input placeholder="Auditee 2" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawan(this.id)" class="form-control" id="auditee2" name="auditee[]" data-toggle="modal" data-target="#karyawanModal" value="{{ $npk_auditee[2] }}" readonly></td>
                <td><input placeholder="Auditee 3" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawan(this.id)" class="form-control" id="auditee3" name="auditee[]" data-toggle="modal" data-target="#karyawanModal" value="{{ $npk_auditee[3] }}" readonly></td>
                <td><input placeholder="Auditee 4" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawan(this.id)" class="form-control" id="auditee4" name="auditee[]" data-toggle="modal" data-target="#karyawanModal" value="{{ $npk_auditee[4] }}" readonly></td>
            </tr>
            <tr>
                <td colspan="4"><input placeholder="List Nama (otomatis)" autocomplete="off" id="listauditee" name="listauditee" class="form-control" readonly></td>
            </tr>
        </table>
    </div>
</div>

    <div class="col-md-12">
        <label class="bubble">REFERENCE OR STANDARD</label> 
        <div class="bubble-content">
        <table class="table-borderless">
        <tr>
            <td>
                {!! Form::label('ref_iatf', 'IATF 16949(*)') !!}
                {!! Form::text('ref_iatf', $get_temuan->iatf_ref, ['class'=>'form-control']) !!}
                {!! $errors->first('ref_iatf', '<p class="help-block">:message</p>') !!}
            </td>
            <td>
                {!! Form::label('ref_iso', 'ISO 9001(*)') !!}
                {!! Form::text('ref_iso', $get_temuan->iso_ref, ['class'=>'form-control']) !!}
                {!! $errors->first('ref_iso', '<p class="help-block">:message</p>') !!}
            </td>
            <td rowspan="1" style="width:10%;vertical-align: top;padding-left: 10px;">
                {!! Form::label('ev_img', 'EVIDENCE FOTO') !!}
                {!! Form::file('ev_img', null, ['class'=>'form-control-file']) !!}
                {!! $errors->first('ev_img', '<p class="help-block">:message</p>') !!}
            </td>
            
        </tr>
        <tr>
            <td>
                {!! Form::label('qms_doc', 'QMS DOC REF') !!}
                {!! Form::text('qms_doc', $get_temuan->qms_doc_ref, ['class'=>'form-control']) !!}
                {!! $errors->first('qms_doc', '<p class="help-block">:message</p>') !!}
            </td>
            <td>
                {!! Form::label('csr', 'CSR') !!}
                {!! Form::text('csr', $get_temuan->csr, ['class'=>'form-control']) !!}
                {!! $errors->first('csr', '<p class="help-block">:message</p>') !!}
            </td>
            <td rowspan="1" style="width:10%;vertical-align: top;padding-left: 10px;">
                {!! Form::label('ev_sv', 'EVIDENCE SOUND/VIDEO') !!}
                {!! Form::file('ev_sv', null, ['class'=>'form-control-file']) !!}
                {!! $errors->first('ev_sv', '<p class="help-block">:message</p>') !!}
            </td>
        </tr>
        </table>
    </div>    
</div>   

<div class="col-md-6">
    <label class="bubble">STATEMENT OF NC(*)</label>
    <div class="bubble-content">
        <textarea rows="10" style="resize: none;" id="snc" name="snc" class="form-control">{{ $get_temuan->statement_of_nc }}</textarea>
    </div>
</div>

<div class="col-md-6">
        <label class="bubble">DETAIL OF PROBLEM(*)</label>
        <div class="bubble-content">
            <textarea rows="10" style="resize: none;" id="dop" name="dop" class="form-control">{{ $get_temuan->detail_problem }}</textarea>
        </div>
    </div>

@section('auditee_sign')
<table class="table-borderless" width="100%;">
<tr>
    <td colspan="3">
        <label>CONTAINMENT OF ACTION</label><textarea id="coa" name="coa" class="form-control"></textarea>
    </td>
</tr>
</table>
@endsection

@section('save_button')
<table class="table-borderless" width="100%;">
    <tr>
        <td style="text-align: right;" colspan="3">
            <button type="button" id="hapus_draft" class="btn btn-danger">HAPUS DRAFT</button>
            <button type="button" id="save_draft" class="btn btn-primary">SAVE DRAFT</button>
            <button type="submit" id="submit" class="btn btn-primary">SAVE</button>
            <!-- <button type="draft" id="draft" class="btn btn-primary">SAVE DRAFT</button> -->
            <!-- <button type="edit" id="edit" class="btn btn-primary">EDIT</button> -->
        </td>
    </tr>
</table>
@endsection

        <!-- Modal line -->
        @include('audit.popup.lineModal')
        <!-- Modal process -->
        @include('audit.popup.processModal  ')
        <!-- Modal Karyawan -->
        @include('audit.popup.karyawanModal')
        <!-- Modal Auditor -->
        @include('audit.popup.auditorModal')


@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){

        $("#kd_dep").children('option').prop('disabled', true);
        $("#kd_sie").children('option').prop('disabled', true);
        $("#line").children('option').prop('disabled', true);
        $("#process").children('option').prop('disabled', true);
    
        $("#btnpopupline").click(function(){
            popupLine();
        });

        $("#btnpopupprocess").click(function(){
            popupProcess();
        });    
        
    });



    $('#form_id').submit(function( event ) {
    event.preventDefault();
    // -- VALIDASI FORM KOSONG
    swal({
          title: 'Anda yakin ingin submit?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, submit',
          cancelButtonText: 'Batal',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
        $.ajax({
        url: "{{ route('auditors.daftartemuanByNo_edit_submit') }}",
        type: 'post',
        data: $('#form_id').serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
          swal(
            'Sukses',
            'Berhasil disubmit!',
            'success'
            ).then(function (){
                $(".btn").prop("disabled", true);                
                // Simulate an HTTP redirect:
                window.location.replace("{{ route('auditors.daftartemuan') }}");
            });
        },
        error: function( _response ){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'error'
            )
        }
    });
        }, function (dismiss) {
          // dismiss can be 'cancel', 'overlay',
          // 'close', and 'timer'
          if (dismiss === 'cancel') {
            // swal(
            //   'Cancelled',
            //   'Your imaginary file is safe :)',
            //   'error'
            // )
          }
        })
});

$('#hapus_draft').click(function( event ) {
    swal({
          title: 'Hapus draft?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
        $.ajax({
        url: "{{ route('auditors.daftartemuanByNo_delete_draft') }}",
        type: 'post',
        data: $('#form_id').serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
          swal(
            'Sukses',
            'Berhasil dihapus!',
            'success'
            ).then(function (){
                $(".btn").prop("disabled", true);                
                // Simulate an HTTP redirect:
                window.location.replace("{{ route('auditors.daftartemuan') }}");
            });
        },
        error: function( _response ){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'error'
            )
        }
    });
        }, function (dismiss) {
          // dismiss can be 'cancel', 'overlay',
          // 'close', and 'timer'
          if (dismiss === 'cancel') {
            // swal(
            //   'Cancelled',
            //   'Your imaginary file is safe :)',
            //   'error'
            // )
          }
        })
});

function changePeriode(ths){
    var finding_no = document.getElementById('finding_no').value.trim();
    var finding_no2 = finding_no.substr(0, finding_no.length - 4)
    var periode_val = $('#periode :selected').val();
    // document.getElementById('finding_no').value = '_'
    document.getElementById('finding_no').value = document.getElementById('finding_no').value.replace(finding_no2.substr(6), '/'+periode_val);
    
}
    
function popupLine() {
    var myHeading = "<p>Popup Line</p>";
    var plant = document.getElementById('kd_plant').value.trim();
    if (plant == ''){
        plant = 'all';
    myHeading = "<p>Popup Line</p><small style='color:red;'>Tidak ada data, plant belum dipilih</small>";
    }
    $("#lineModalLabel").html(myHeading);
    var url = "{{ route('datatables.popupLineIA', ['param']) }}";
    url = url.replace('param', plant);
    var lookupLine = $('#lookupLine').DataTable({
        processing: true,
        // serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        responsive: true,
        // "scrollX": true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        "order": [[0, 'asc']],
        columns: [
            { data: 'xnm_line', name: 'xnm_line'},
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
            // $('div.dataTables_filter input').focus();
            $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
                var dataArr = [];
                var rows = $(this);
                var rowData = lookupLine.rows(rows).data();
                $.each($(rowData),function(key,value){
                    document.getElementById("line").value = value["xnm_line"];
                    $('#lineModal').modal('hide');
                });
            });
            $('#lineModal').on('hidden.bs.modal', function () {
                var line = document.getElementById("line").value.trim();
                if(line === '') {
                    document.getElementById("line").value = "";
                    $('#line').focus();
                }
            });
        },
    });
}

function popupProcess() {
    var myHeading = "<p>Popup Line</p>";
    var plant = document.getElementById('kd_plant').value.trim();
    if (plant == ''){
        plant = 'all';
    myHeading = "<p>Popup Line</p><small style='color:red;'>Tidak ada data, plant belum dipilih</small>";
    }
    $("#processModalLabel").html(myHeading);
    var url = "{{ route('datatables.popupProcessIA', ['param']) }}";
    url = url.replace('param', plant);
    var lookupProcess = $('#lookupProcess').DataTable({
        processing: true,
        // serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        responsive: true,
        // "scrollX": true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        "order": [[0, 'asc']],
        columns: [
            { data: 'xnama_proses', name: 'xnama_proses'},
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
            // $('div.dataTables_filter input').focus();
            $('#lookupProcess tbody').on( 'dblclick', 'tr', function () {
                var dataArr = [];
                var rows = $(this);
                var rowData = lookupProcess.rows(rows).data();
                $.each($(rowData),function(key,value){
                    document.getElementById("process").value = value["xnama_proses"];
                    $('#processModal').modal('hide');
                });
            });
            $('#processModal').on('hidden.bs.modal', function () {
                var line = document.getElementById("line").value.trim();
                if(line === '') {
                    document.getElementById("line").value = "";
                    $('#process').focus();
                }
            });
        },
    });
}

function popupKaryawan(ths) {

    if ($('#auditee1').val() == ''){
        ths = 'auditee1';
    } else if($('#auditee2').val() == ''){
        ths = 'auditee2';
    } else if($('#auditee3').val() == ''){
        ths = 'auditee3';       
    } else if($('#auditee3').val() == ''){
        ths = 'auditee3';     
    } else if($('#auditee4').val() == ''){
        ths = 'auditee4';     
    }
        var myHeading = "<p>Popup Karyawan AUDITEE</p>";
        $("#karyawanModalLabel").html(myHeading);
        var url = "{{ route('datatables.popupKaryawanIA') }}";
        var lookupKaryawan = $('#lookupKaryawan').DataTable({
            processing: true,
            serverSide: true,
            "pagingType": "numbers",
            ajax: url,
            "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            responsive: true,
            // "scrollX": true,
            // "scrollY": "500px",
            // "scrollCollapse": true,
            "order": [[1, 'asc']],
            columns: [
                { data: 'npk', name: 'npk'},
                { data: 'nama', name: 'nama'},
                { data: 'desc_dep', name: 'desc_dep'}
            ],
            "bDestroy": true,
            "initComplete": function(settings, json) {
            // $('div.dataTables_filter input').focus();
            $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
                var dataArr = [];
                var rows = $(this);
                var rowData = lookupKaryawan.rows(rows).data();
                $.each($(rowData),function(key,value){
                    document.getElementById(ths).value = value["npk"];
                    document.getElementById('listauditee').value += value["nama"] + ',  ';
                    $('#karyawanModal').modal('hide');
                });
            });
            $('#karyawanModal').on('hidden.bs.modal', function () {
                var line = document.getElementById(ths).value.trim();
                if(line === '') {
                    document.getElementById(ths).value = "";
                    $('#'+ths).focus();
                }
            });
        },
        });
    }

function popupKaryawanAuditor(ths, thsrole) {
    var remark;

    if ($('#auditor1').val() == ''){
        ths = 'auditor1';
        remark = "LEAD AUDITOR"
    } else if($('#auditor2').val() == ''){
        ths = 'auditor2';
        remark = "AUDITOR";
    } else if($('#auditor3').val() == ''){
        ths = 'auditor3';
        remark = "AUDITOR";    
    } else if($('#auditor3').val() == ''){
        ths = 'auditor3';
        remark = "AUDITOR"; 
    } else if($('#auditor4').val() == ''){
        ths = 'auditor4';
        remark = "AUDITOR";
    }
    
    var myHeading = "<p>Popup Karyawan AUDITOR</p>";
    $("#auditorModalLabel").html(myHeading);
    var url = "{{ route('datatables.popupKaryawanAuditor', 'param') }}";
    url = url.replace('param', remark)
    var lookupAuditor = $('#lookupAuditor').DataTable({
        processing: true,
        serverSide: false,
        "pagingType": "numbers",
        ajax: url,
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        responsive: true,
        // "scrollX": true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        "order": [[1, 'asc']],
        columns: [
            { data: 'npk', name: 'npk'},
            { data: 'nama', name: 'nama'},
            { data: 'desc_dep', name: 'desc_dep'}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
            // $('div.dataTables_filter input').focus();
            $('#lookupAuditor tbody').on( 'dblclick', 'tr', function () {
                var dataArr = [];
                var rows = $(this);
                var rowData = lookupAuditor.rows(rows).data();
                $.each($(rowData),function(key,value){
                    document.getElementById(ths).value = value["npk"];
                    document.getElementById('listauditor').value += value["nama"] + ',  ';
                    $('#auditorModal').modal('hide');
                });
            });
            $('#auditorModal').on('hidden.bs.modal', function () {
                var line = document.getElementById(ths).value.trim();
                if(line === '') {
                    document.getElementById(ths).value = "";
                    $('#'+ths).focus();
                }
            });
        },
    });
}

function clear_auditor(){
    $('#auditor1').val('');
    $('#auditor2').val('');
    $('#auditor3').val('');
    $('#auditor4').val('');
    $('#listauditor').val('');


}

function clear_auditee(){
    $('#auditee1').val('');
    $('#auditee2').val('');
    $('#auditee3').val('');
    $('#auditee4').val('');
    $('#listauditee').val('');

}
</script>

@endsection

