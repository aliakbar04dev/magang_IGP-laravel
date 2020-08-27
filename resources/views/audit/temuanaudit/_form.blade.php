<div class="col-md-6">
<label class="bubble">AREA AUDIT</label>
<div class="bubble-content">
    <div>
        {!! Form::label('plant', 'PLANT(*)') !!}
        {!! Form::select('kd_plant', array('' => '', '1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4', 'A' => 'KIM-1A', 'B' => 'KIM-1B'), 'kd_plant', ['id' => 'kd_plant', 'class'=>'form-control select2', 'style' => 'width:100%;']) !!}
        {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('div', 'DIVISI(*)') !!}
        <select class="form-control select2" id="kd_div" name="kd_div" style="width:100%;">
            <option></option>
            @foreach ($getdiv as $div)
             @if ($div->desc_div != null)
                <option value="{{ $div->kd_div }}">{{ $div->desc_div }}</option>
            @endif
            @endforeach
        </select>
        {!! $errors->first('kd_dep', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('dept', 'DEPT(*)') !!}
        <select class="form-control select2" id="kd_dep" name="kd_dep" style="width:100%;">
            <option></option>
            @foreach ($getdep as $dep)
            <option value="{{ $dep->kd_dep }}">{{ $dep->desc_dep }}</option>
            @endforeach
        </select>
        {!! $errors->first('kd_dep', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('sect', 'SEKSI(*)') !!}
        <select class="form-control select2" id="kd_sie" name="kd_sie" style="width:100%;">
            <option></option>
            @foreach ($getsie as $sie)
            <option value="{{ $sie->kd_sie }}">{{ $sie->desc_sie }}</option>
            @endforeach
        </select>
        {!! $errors->first('kd_dep', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
            {!! Form::label('line', 'LINE') !!}
            <select class="form-control select2" id="line" name="line" style="width:100%;">
                <option></option>
                @foreach ($getline as $line)
                <option plant="{{ $line->xkd_plant }}" value="{{ $line->xkd_line }}">{{ $line->xnm_line }}</option>
                @endforeach
            </select>
            {!! $errors->first('kd_dep', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
            {!! Form::label('process', 'PROCESS') !!}
            <select class="form-control select2" id="process" name="process" style="width:100%;">
                <option></option>
                @foreach ($getprocess as $process)
                <option plant="{{ $process->xkd_line }}" value="{{ $process->xkd_proses }}">{{ $process->xnama_proses }}</option>
                @endforeach
            </select>
            {!! $errors->first('kd_dep', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>

<div class="col-md-6">
<label class="bubble">DETAIL</label>
<div class="bubble-content">
    <div>
        {!! Form::label('finding_no', 'FINDING NO.') !!}
        {!! Form::text('finding_no', $get_finding_number, ['class'=>'form-control', 'placeholder' => 'Finding No.', 'required', 'readonly' => '']) !!}
        {!! $errors->first('finding_no', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('tgl', 'TANGGAL(*)') !!}
        {!! Form::date('tgl', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now(), 'style' => 'padding-top: 0px;']) !!}
        {!! $errors->first('tgl', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('category', 'CATEGORY FINDING(*)') !!}
        {!! Form::select('cat', array('' => '', 'MAJOR' => 'MAJOR', 'MINOR' => 'MINOR'), 'cat', ['class'=>'form-control select2', 'style' => 'width:100%;' , 'id' => 'cat']) !!}
        {!! $errors->first('cat', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('type', 'AUDIT TYPE(*)') !!}
        {!! Form::select('kd_type', array('' => '', 'INTERNAL AUDIT' => 'INTERNAL AUDIT', 'FINANCIAL AUDIT' => 'FINANCIAL AUDIT', 'OPERATIONAL AUDIT' => 'OPERATIONAL AUDIT', 'SURVEILLANCE AUDIT' => 'SURVEILLANCE AUDIT', 'CUSTOMER AUDIT' => 'CUSTOMER AUDIT'), 'kd_type', ['class'=>'form-control select2', 'style' => 'width:100%;', 'id' => 'kd_type']) !!}
        {!! $errors->first('kd_type', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('shift', 'SHIFT(*)') !!}
        {!! Form::select('kd_shift', array('' => '', '1' => '1', '2' => '2', '3' => '3'), 'kd_shift', ['class'=>'form-control select2', 'style' => 'width:100%;', 'id' => 'kd_shift']) !!}
        {!! $errors->first('kd_shift', '<p class="help-block">:message</p>') !!}
    </div>
    <div style="margin-top: 8px;">
        {!! Form::label('periode', 'PERIODE(*)') !!}
        {!! Form::select('periode', array('' => '', 'I' => 'I (SATU)', 'II' => 'II (DUA)'), 'periode', ['class'=>'form-control select2', 'style' => 'width:100%;', 'id' => 'periode', 'onchange' => 'changePeriode()']) !!}
        {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>

<div class="col-md-6">
<label class="bubble">AUDITOR</label> <button type="button" onclick="clear_auditor()" id="clearauditor" class="btn btn-danger btn-xs">CLEAR</button>
    <div class="bubble-content">
        <table>
        <tr>
            <td><input placeholder="Auditor 1" autocomplete="off" style="background-color: #d0fdda;text-align: center;" onclick="popupKaryawanAuditor(this.id)" class="form-control" id="auditor1" role="LEAD AUDITOR" name="auditor[]" data-toggle="modal" data-target="#auditorModal" readonly></td>
            <td><input placeholder="Auditor 2" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawanAuditor(this.id)" class="form-control" id="auditor2" role="AUDITOR" name="auditor[]" data-toggle="modal" data-target="#auditorModal" readonly></td>
            <td><input placeholder="Auditor 3" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawanAuditor(this.id)" class="form-control" id="auditor3" role="AUDITOR" name="auditor[]" data-toggle="modal" data-target="#auditorModal" readonly></td>
            <td><input placeholder="Auditor 4" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawanAuditor(this.id)" class="form-control" id="auditor4" role="AUDITOR" name="auditor[]" data-toggle="modal" data-target="#auditorModal" readonly></td>
        </tr>
        <tr>
            <td colspan="4"><input placeholder="List Nama (otomatis)" autocomplete="off" id="listauditor" name="listauditee" class="form-control" readonly></td>
        </tr>
    </table>
        </div>
    </div>

    <div class="col-md-6">
    <label class="bubble">AUDITEE</label> <button type="button" onclick="clear_auditee()" id="clearauditee" class="btn btn-danger btn-xs">CLEAR</button>
    <div class="bubble-content style="margin-top: 8px;">
        <table>
         <tr>
                <td><input placeholder="Auditee 1" autocomplete="off" style="background-color: #d0fdda;text-align: center;" onclick="popupKaryawan(this.id)" class="form-control" id="auditee1" name="auditee[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                <td><input placeholder="Auditee 2" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawan(this.id)" class="form-control" id="auditee2" name="auditee[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                <td><input placeholder="Auditee 3" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawan(this.id)" class="form-control" id="auditee3" name="auditee[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                <td><input placeholder="Auditee 4" autocomplete="off" style="background-color: white;text-align: center;" onclick="popupKaryawan(this.id)" class="form-control" id="auditee4" name="auditee[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
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
                {!! Form::text('ref_iatf', null, ['class'=>'form-control']) !!}
                {!! $errors->first('ref_iatf', '<p class="help-block">:message</p>') !!}
            </td>
            <td>
                {!! Form::label('ref_iso', 'ISO 9001(*)') !!}
                {!! Form::text('ref_iso', null, ['class'=>'form-control']) !!}
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
                {!! Form::text('qms_doc', null, ['class'=>'form-control']) !!}
                {!! $errors->first('qms_doc', '<p class="help-block">:message</p>') !!}
            </td>
            <td>
                {!! Form::label('csr', 'CSR') !!}
                {!! Form::text('csr', null, ['class'=>'form-control']) !!}
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
        <textarea rows="10" style="resize: none;" id="snc" name="snc" class="form-control"></textarea>
    </div>
</div>

<div class="col-md-6">
        <label class="bubble">DETAIL OF PROBLEM(*)</label>
        <div class="bubble-content">
            <textarea rows="10" style="resize: none;" id="dop" name="dop" class="form-control"></textarea>
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
            <button type="button" id="save_draft" class="btn btn-primary">SAVE DRAFT</button>
            <button type="submit" id="submit" class="btn btn-primary">SUBMIT</button>
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

        $("#kd_plant").select2({
            placeholder: "PILIH PLANT...",
            allowClear: true
        });

        $("#kd_dep").select2({
            placeholder: "PILIH DEPARTEMEN...",
        });

        $("#kd_div").select2({
            placeholder: "PILIH DIVISI...",
        });

        $("#kd_sie").select2({
            placeholder: "PILIH SEKSI...",
        });

        $("#line").select2({
            placeholder: "PILIH LINE...",
        });

        $("#process").select2({
            placeholder: "PILIH PROSES...",
        });

        $("#cat").select2({
            placeholder: "PILIH CATEGORY...",
            allowClear: true
        })

        $("#kd_type").select2({
            placeholder: "PILIH TIPE...",
            allowClear: true
        })

        $("#kd_shift").select2({
            placeholder: "PILIH SHIFT...",
            allowClear: true
        })

        $("#periode").select2({
            placeholder: "PILIH PERIODE...",
        })

    $("#kd_div").change(function() {
        $("#kd_dep").children('option').prop('disabled', true);
        $("#kd_dep").children("option[value^=" + $(this).val() + "]").prop('disabled', false);
        $("#kd_dep").select2({
            placeholder: "PILIH DEPARTEMEN...",
        });
        $("#kd_sie").select2({
            placeholder: "PILIH SEKSI...",
        });
        $("#kd_dep").val('').trigger('change');
        $("#kd_sie").val('').trigger('change');
    });

    $("#kd_dep").change(function() {
        $("#kd_sie").children('option').prop('disabled', true);
        $("#kd_sie").children("option[value^=" + $(this).val() + "]").prop('disabled', false);
        $("#kd_sie").select2({
            placeholder: "PILIH SEKSI...",
        });
        $("#kd_sie").val('').trigger('change');
    });

    $("#kd_plant").change(function() {
        $("#line").children('option').prop('disabled', true);
        $("#line").children("option[plant^=" + $(this).val() + "]").prop('disabled', false);
        $("#line").select2({
            placeholder: "PILIH LINE...",
        });
        $("#line").val('').trigger('change');
        $("#process").val('').trigger('change');
    });

    $("#line").change(function() {
        $("#process").children('option').prop('disabled', true);
        $("#process").children("option[plant^=" + $(this).val() + "]").prop('disabled', false);
        $("#process").select2({
            placeholder: "PILIH LINE...",
        });
        $("#process").val('').trigger('change');
    });
        
        
    });



    $('#form_id').submit(function( event ) {
    event.preventDefault();
    // VALIDASI FORM KOSONG
    var val_plant = $('#kd_plant :selected').val();
    var val_dep = $('#kd_dep :selected').val();
    var val_cat = $('#cat :selected').val();
    var val_type = $('#kd_type :selected').val();
    var val_shift = $('#kd_shift :selected').val();
    var val_periode = $('#periode :selected').val();
    var val_line = document.getElementById('line').value;
    var val_process = document.getElementById('process').value;
    var val_snc = document.getElementById('snc').value;
    var val_qms = document.getElementById('qms_doc').value;
    var val_iatf = document.getElementById('ref_iatf').value;
    var val_iso = document.getElementById('ref_iso').value;
    var val_dop = document.getElementById('dop').value;
    var val_auditor_wajib = document.getElementById('auditor1').value;
    var val_auditee_wajib = document.getElementById('auditee1').value;


    if(val_plant == ''||val_dep == ''||val_cat == ''||
    val_type == ''||val_shift == ''||val_periode == ''||
    val_line == ''||val_line == null||val_process == ''||
    val_process == null || val_snc == ''||val_snc == null||
    val_qms == ''||val_iatf == ''||val_iatf == null||
    val_iso == ''||val_iso == null||
    val_dop == ''||val_dop == null||
    val_auditor_wajib == ''||val_auditor_wajib == null||
    val_auditee_wajib == ''||val_auditee_wajib == null){
        swal(
            'Info',
            'Data yang bertanda (*) atau (**) belum lengkap!',
            'info'
            )        
            return;
    }
    // -- VALIDASI FORM KOSONG
    swal({
          title: 'Submit input temuan audit?',
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
        url: "{{ route('auditors.temuanauditform_submit') }}",
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

$('#save_draft').click(function( ) {
    // VALIDASI FORM KOSONG
    var val_plant = $('#kd_plant :selected').val();
    var val_dep = $('#kd_dep :selected').val();
    var val_cat = $('#cat :selected').val();
    var val_type = $('#kd_type :selected').val();
    var val_shift = $('#kd_shift :selected').val();
    var val_periode = $('#periode :selected').val();
    var val_line = document.getElementById('line').value;
    var val_process = document.getElementById('process').value;
    var val_snc = document.getElementById('snc').value;
    var val_qms = document.getElementById('qms_doc').value;
    var val_iatf = document.getElementById('ref_iatf').value;
    var val_iso = document.getElementById('ref_iso').value;
    var val_dop = document.getElementById('dop').value;
    var val_auditor_wajib = document.getElementById('auditor1').value;
    var val_auditee_wajib = document.getElementById('auditee1').value;


    if(val_plant == ''||val_dep == ''||val_cat == ''||
    val_type == ''||val_shift == ''||val_periode == ''||
    val_line == ''||val_line == null||val_process == ''||
    val_process == null || val_snc == ''||val_snc == null||
    val_qms == ''||val_iatf == ''||val_iatf == null||
    val_iso == ''||val_iso == null||
    val_dop == ''||val_dop == null||
    val_auditor_wajib == ''||val_auditor_wajib == null||
    val_auditee_wajib == ''||val_auditee_wajib == null){
        swal(
            'Info',
            'Data yang bertanda (*) atau (**) belum lengkap!',
            'info'
            )        
            return;
    }
    // -- VALIDASI FORM KOSONG
    swal({
          title: 'Simpan sebagai draft?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, simpan',
          cancelButtonText: 'Batal',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
        $.ajax({
        url: "{{ route('auditors.temuanauditform_save_draft') }}",
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

