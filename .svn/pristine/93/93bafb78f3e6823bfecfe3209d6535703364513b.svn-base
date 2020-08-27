@extends('layouts.app')
@section('content')

<style>
.textarea_col{
    margin-bottom:30px;
}

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
}

textarea{resize: none;}

label.header {
    display:block;
    margin-bottom: 0px;
    text-align: center;
    background-color:#f7644c;
    color:white;
    border-radius: 2px 2px 0px 0px;
    padding-bottom: 5px;
    padding-top: 5px;
    font-weight:600;
    }
textarea { display:block; }

@media screen and (max-width: 1000px) {
    #arrow1 {
        display: none !important;
    }
}

.loader {
    border: 3px solid #f9eaea;
    border-top: 3px solid #31ff60;
    border-bottom: 3px solid #31ff60;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 0.7s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>Turtle Diagram</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Turtle Diagram</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <!-- Form Izin Terlambat -->
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                        <div class="box-header with-border">
                                <h3 class="box-title">Form Turtle Diagram</h3>
                                <div class="box-tools pull-right">
                                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                  </button>
                                </div>
                              </div>
                    <div class="box-body">
                        <div class="refresh-all">
                            <div id="arrow1">
                            <p style="position: absolute;margin-top: 422px;margin-left: 31.8%;color:#4e514e;font-size: 20px;"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></p>
                            <p style="position: absolute;margin-top: 422px;margin-left: 64.4%;color:#4e514e;font-size: 20px;"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></p>
                            <p style="position: absolute;margin-top: 313px;margin-left: 31.8%;color:#4e514e;font-size: 20px;transform: rotate(45deg);"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></p>
                            <p style="position: absolute;margin-top: 313px;margin-left: 64.4%;color:#4e514e;font-size: 20px;transform: rotate(135deg);"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></p>
                            <p style="position: absolute;margin-top: 313px;margin-left: 48%;color:#4e514e;font-size: 20px;transform: rotate(90deg);"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></p>
                            <p style="position: absolute;margin-top: 520px;margin-left: 31.8%;color:#4e514e;font-size: 20px;transform: rotate(-45deg);"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></p>
                            <p style="position: absolute;margin-top: 520px;margin-left: 64.4%;color:#4e514e;font-size: 20px;transform: rotate(-135deg);"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></p>
                            <p style="position: absolute;margin-top: 520px;margin-left: 48%;color:#4e514e;font-size: 20px;transform: rotate(-90deg);"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></p>
                            </div>
                        <div id="refresh-td-list">
                            <div id="td-list" style="display:block;margin-left: 15px;">
                                <b style="display:block;font-weight: 600;margin-bottom: 3px;">TURTLE DIAGRAM PROCESS</b>
                                @if ($last_td != null)
                                <div class="col-md-12" style="margin-bottom: 8px;padding-right: 0px;padding-left: 0px;">
                                <select autocomplete="off" onchange="select_td()" style="width:250px;" id="select-td" class="form-control input-sm">
                                    @foreach ($all_td as $td)
                                        @if ($last_td->kd_td == $td->kd_td)
                                            @if (substr($last_td->kd_td, 8) == '_D')
                                            <option value="{{ $td->kd_td }}" selected>{{ $td->td_name }}</option>
                                            @else
                                            <option value="{{ $td->kd_td }}" selected>{{ $td->td_name }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $td->kd_td }}">{{ $td->td_name }}</option>
                                        @endif
                                    @endforeach
                                    @foreach ($all_draft as $draft)
                                        @if ($last_td->kd_td == $draft->kd_td)
                                            <option value="{{ $last_td->kd_td }}" selected>{{ $last_td->td_name }} (DRAFT)</option>
                                        @else
                                            <option value="{{ $draft->kd_td }}" selected>{{ $draft->td_name }} (DRAFT)</option>
                                        @endif
                                    @endforeach
                                </select>&nbsp;
                                <div id="loading_icon" style="display: none;"><div class="loader" style="display: inline-block;margin-bottom: -5px;"></div> Menyimpan perubahan...</div>
                                </div>
                                <div class="col-md-3" style="margin-bottom: 10px;margin-right: -35px;"><b style="font-weight: 600;margin-left: -15px;">DATE</b>
                                    <input autocomplete="off" type="date" class="form-control" id="time" name="time" style="width:100%;line-height: 15px;margin-left: -15px;" value="{{ $last_td->date }}" readonly>
                                </div>
                                <div id="refresh-btn-action" class="col-md-9" style="margin-top: 20px; margin-bottom: 10px;">
                                    <div id="btn-action">
                                    <button id="delete_diagram" class="btn btn-primary" style="margin-right: 8px;margin-bottom:0px;" onclick="deletediagram()">DELETE</button>
                                    <button id="rename_diagram" class="btn btn-primary" style="margin-right: 8px;margin-bottom:0px;" onclick="renamediagram()">RENAME</button>
                                    @if (substr($last_td->kd_td, 8) != '_D')
                                        <button id="new" class="btn btn-success" style="margin-bottom:0px;" onclick="newdiagram()">CREATE NEW</button>
                                    @else
                                        <button id="save" class="btn btn-primary" style="margin-bottom:0px;margin-right:8px;" onclick="save()">SAVE DIAGRAM</button>
                                        <button id="new" class="btn btn-success" style="margin-bottom:0px;" onclick="newdiagram()">CREATE NEW</button>
                                    @endif
                                </div>
                            </div>

                            @else
                            TURTLE01_D
                            <input type="hidden" id="kd_td" value="TURTLE01_D">
                            @endif
                            
                            </div>
                        </div>
                        <div id="refresh-content">
                            <div id="rcontent">
                        
                        <div class="col-md-4 textarea_col">
                            <label class="header" for="what">WITH WHAT?</label>
                            <textarea autocomplete="off" name="what" id="what" column="what_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->what_content }}</textarea>
                        </div>
                        <div class="col-md-4 textarea_col">
                            <label class="header" for="risk">WHAT IS THE RISK? <!--i>What is the strategy</i--></label>
                            <textarea autocomplete="off" name="risk" id="risk" column="risk_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->risk_content }}</textarea>
                        </div>
                        <div class="col-md-4 textarea_col">
                            <label class="header" for="input">WHO?</label>
                            <textarea autocomplete="off" name="who" id="who" column="who_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->who_content }}</textarea>
                        </div>
                        <div class="col-md-4 textarea_col">
                            <label class="header" for="input">INPUT?</label>
                            <textarea autocomplete="off" name="input" id="input" column="input_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->input_content }}</textarea>
                        </div>
                        <div class="col-md-4 textarea_col">
                            <label class="header" for="process">PROCESS?</label>
                            <textarea autocomplete="off" name="process" id="process" column="process_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->process_content }}</textarea>
                        </div>
                        <div class="col-md-4 textarea_col">
                            <label class="header" for="output">OUTPUT?</label>
                            <textarea autocomplete="off" name="output" id="output" column="output_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->output_content }}</textarea>
                        </div>
                        <div class="col-md-4" style="margin-bottom:10px;">
                            <label class="header" for="how">HOW?</label>
                            <textarea autocomplete="off" name="how" id="how" column="how_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->how_content }}</textarea>
                        </div>
                        <div class="col-md-4" style="margin-bottom:10px;">
                            <label class="header" for="supporting">SUPPORTING PROCESS?</label>
                            <textarea autocomplete="off" name="supporting" id="supporting" column="supporting_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->supporting_content }}</textarea>
                        </div>
                        <div class="col-md-4" style="margin-bottom:10px;">
                            <label class="header" for="result">WHAT RESULT/KPI?</label>
                            <textarea autocomplete="off" name="result" id="result" column="result_content" rows="6" class="form-control" onchange="draft(this.id)">{{ $last_td->result_content }}</textarea>
                        </div>

                        @if (substr($last_td->kd_td, 8) != '_D')
                        <div id="refresh-review">
                        <div id="review-content">
                        <div class="col-md-12" style="margin-bottom:10px;"><b style="font-weight: 600;">REVIEWED BY AUDITEE</b>
                            <div style="overflow-x:auto;width: 92%;">
                            <table id="re_auditee" style="margin-left: 0px;">
                                <tr>
                                    @if ($all_review->count() != 0)
                                        @foreach ($all_review as $npk)
                                            @if ($npk->status == 'AUDITEE')
                                            <td><input type="text" namakar="{{ $npk->nama }}" depkar="{{ $npk->desc_dep }}" class="form-control" id="reviewby{{$loop->iteration}}" onclick="npkInfo(this.id)" name="reviewby{{$loop->iteration}}" style="text-align: center; width:100px; margin-right:8px;cursor:pointer;" value="{{ $npk->npk_reviewed }}" readonly>
                                            </td>
                                            @endif
                                        @endforeach
                                    @endif
                                    <td><button class="btn btn-success" id="reviewtambah" onclick="popupKaryawan()" data-toggle="modal" data-target="#karyawanModal" readonly><span class="glyphicon glyphicon-plus"></span></button></b></td>
                                </tr>
                            </table>
                            @if ($all_review->count() == 0)
                                <div style="padding-bottom:15px;">Belum ada review!</div>
                            @endif
                            </div>
                        </div>
                    </div>
                        <div class="col-md-12"><b style="font-weight: 600;">REVIEWED BY AUDITOR</b>
                            <div style="overflow-x:auto;width: 92%;">
                            <table id="re_auditor" style="margin-left: 0px;">
                                <tr>
                                    @if ($all_review->count() != 0)
                                        @foreach ($all_review as $npk)
                                            @if ($npk->status == 'AUDITOR')
                                            <td><input type="text" namakar="{{ $npk->nama }}" depkar="{{ $npk->desc_dep }}" class="form-control" id="reviewby{{$loop->iteration}}" onclick="npkInfo(this.id)" name="reviewby{{$loop->iteration}}" style="text-align: center; width:100px; margin-right:8px;cursor:pointer;" value="{{ $npk->npk_reviewed }}" readonly>
                                            </td>
                                            @endif                                        
                                        @endforeach
                                    @endif
                                    <td><button class="btn btn-success" id="reviewtambah" onclick="popupKaryawanAuditor()" data-toggle="modal" data-target="#auditorModal" readonly><span class="glyphicon glyphicon-plus"></span></button></b></td>
                                </tr>
                            </table>
                            @if ($all_review->count() == 0)
                                <div style="padding-bottom:15px;">Belum ada review!</div>
                            @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    </div>
                    </div>
                </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

        <!-- Modal Karyawan -->
        @include('audit.popup.karyawanModal')
        <!-- Modal Auditor -->
        @include('audit.popup.auditorModal')
@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
      $("#select-td").select2();
      $("#select-td select").val("{{ $last_td->kd_td }}")
});

function edit(ths){
    var content = document.getElementById(ths.substring(5));
    var kd_td = document.getElementById('select-td').value.trim();
    var button = document.getElementById(ths);
    var column = $('#'+ths).attr('column');
    var btnxsclass = $('.btn-xs').not(button);
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.edit_turtle') }}"
    if (button.innerHTML == 'EDIT'){
        button.innerHTML = 'SAVE';
        content.readOnly = false;
        content.focus();
        btnxsclass.hide();
    }  else {
        $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                column   : column,
                content : content.value,
                kd_td : kd_td,
                _token  : token,
            },
            success: function( _response ){
                console.log(_response);
                button.innerHTML = 'EDIT';
                content.readOnly = true;
                btnxsclass.show(); 
            },
            error: function( _response ){
                swal(
                'Terjadi kesalahan',
                'Segera hubungi Admin!',
                'error'
                )
            }
        });
    }
}

function draft(ths){
    document.getElementById('loading_icon').style.display = "inline-block";
    var content = document.getElementById(ths);
    var column = $('#'+ths).attr('column');
    var kd_td = document.getElementById('select-td').value.trim();
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.edit_turtle') }}"
        $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                column   : column,
                content : content.value,
                kd_td : kd_td,
                _token  : token,
            },
            success: function( _response ){
                console.log(_response);
                document.getElementById('loading_icon').style.display = "none";
            },
            error: function( _response ){
                swal(
                'Terjadi kesalahan',
                'Segera hubungi Admin!',
                'error'
                )
            }
        });
}

function save(){
    var kd_td = document.getElementById('select-td').value.trim();
    var c_what = document.getElementById('what').value.trim();
    var c_risk = document.getElementById('risk').value.trim();
    var c_who = document.getElementById('who').value.trim();
    var c_input = document.getElementById('input').value.trim();
    var c_process = document.getElementById('process').value.trim();
    var c_output = document.getElementById('output').value.trim();
    var c_how = document.getElementById('how').value.trim();
    var c_supporting = document.getElementById('supporting').value.trim();
    var c_result = document.getElementById('result').value.trim();
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.save_turtle') }}"
    swal({
            title: 'Simpan Diagram?',
            text: 'Anda masih dapat mengubah diagram yang sudah disimpan',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            swal({
                title: 'Loading...',
                showConfirmButton: false
            }) 
            $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                kd_td : kd_td,
                c_what : c_what,
                c_risk : c_risk,
                c_who : c_who,
                c_input : c_input,
                c_process : c_process,
                c_output : c_output,
                c_how : c_how,
                c_supporting : c_supporting,
                c_result : c_result,
                _token  : token,
            },
            success: function( _response ){
                console.log(_response);
                refresh_page();
                swal(
                'Sukses',
                'Berhasil menyimpan',
                'success'
                )
            },
            error: function( _response ){
                swal(
                'Terjadi kesalahan',
                'Segera hubungi Admin!',
                'error'
                )
            }
        });
    })

}

function select_td(){
    swal({
        title: 'Loading...',
       showConfirmButton: false,
        allowEscapeKey : false,
       allowOutsideClick: false
    })
    var param = document.getElementById('select-td').value.trim();
    var url = "{{route('auditors.turtleform_load', 'param')}} #rcontent";
    var url2 = "{{route('auditors.turtleform_load', 'param')}} #btn-action";
    url = url.replace('param', param);
    url2 = url2.replace('param', param);

    // alert(param);
    $('#refresh-content').load(url, function(){
        swal.close();
    });
    $('#refresh-btn-action').load(url2);

}

function refresh_page(){
    $('.box-body').load("{{route('auditors.turtleform')}} .refresh-all", function(){
    
    $("#select-td").select2();
    $("#select-td").val("{{ $last_td->kd_td }}")
    $("#loading_icon").hide();

    });
}


function newdiagram(){
    var url = "{{route('auditors.create_turtle') }}"
    var token = document.getElementsByName('_token')[0].value.trim();
    swal({
        title: 'Tulis nama diagram baru',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: 'Buat Diagram',
    }).then(function (value){
        $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                nama : value,
                _token : token,
            },
            success: function( _response ){
                console.log(_response);
                swal({
                    title: 'Loading...',
                    text: 'Memproses buat diagram baru',
                    showConfirmButton: false,
                    allowEscapeKey : false,
                    allowOutsideClick: false
                })
                location.reload(); 
            },
            error: function(){
                swal(
                'Terjadi kesalahan',
                'Segera hubungi Admin!',
                'error'
                )
            }
        });
    })
}

function deletediagram(){
    var kd_td = document.getElementById('select-td').value.trim();
    if (kd_td == 'TURTLE01'){
        swal(
        'Error',
        'Turtle Diagram Default tidak bisa dihapus',
        'error'
        )
        return;
    }
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.delete_turtle') }}"
    swal({
            title: 'Hapus Diagram?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            swal({
                title: 'Loading...',
                showConfirmButton: false
            }) 
            $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                kd_td : kd_td,
                _token  : token,
            },
            success: function( _response ){
                console.log(_response);
                location.reload(); 
                $("#select-td select").val("{{ $last_td->kd_td }}")
                swal(
                'Sukses',
                'Berhasil menghapus',
                'success'
                )
            },
            error: function( _response ){
                swal(
                'Terjadi kesalahan',
                'Segera hubungi Admin!',
                'error'
                )
            }
        });
    })
}

function renamediagram(){

    var url = "{{route('auditors.rename_turtle') }}"
    var kd_td = document.getElementById('select-td').value.trim();
    if (kd_td == 'TURTLE01'){
        swal(
        'Error',
        'Turtle Diagram Default tidak bisa direname',
        'error'
        )
        return;
    }
    var token = document.getElementsByName('_token')[0].value.trim();
    var getName = $("#select-td option:selected").text();
    swal({
        title: 'Edit nama diagram',
        input: 'text',
        inputValue : getName,
        showCancelButton: true,
        confirmButtonText: 'Rename',
    }).then(function (value){
        $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                kd_td : kd_td,
                nama : value,
                _token : token,
            },
            success: function( _response ){
                console.log(_response);
                swal(
                'Sukses',
                'Berhasil rename',
                'success'
                )
                refresh_page();
            },
            error: function(){
                swal(
                'Terjadi kesalahan',
                'Segera hubungi Admin!',
                'error'
                )
            }
        });
    })
}

function popupKaryawan() {
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
                        var kd_td = document.getElementById('select-td').value.trim();
                        var url = "{{ route('auditors.add_review_turtle') }}";
                        var token = document.getElementsByName('_token')[0].value.trim();
                        var jumlah_auditee = document.getElementById('re_auditee').rows[0].cells.length;
                        var jumlah_auditor = document.getElementById('re_auditor').rows[0].cells.length;
                        var total = jumlah_auditee + jumlah_auditor - 2;
                        if (total != 0){
                        for (i = 0; i < total; i++){
                            var cek_npk = document.getElementById('reviewby' + (i + 1));
                            if(value["npk"] == cek_npk.value){
                                swal(
                                'Error',
                                'NPK ' + cek_npk.value + ' sudah terdaftar dalam daftar review!',
                                'error'
                                )
                                return;
                            }
                        }
                    }
                                $('#karyawanModal').modal('hide');
                                $.ajax({
                                    url      : url,
                                    type     : 'POST',
                                    dataType : 'json',
                                    data     : {
                                        kd_td : kd_td,
                                        npk : value["npk"],
                                        _token : token,
                                    },
                                    success: function( _response ){
                                        console.log(_response);
                                        select_td();
                                        swal(
                                        'Sukses',
                                        'Berhasil menambahkan review',
                                        'success'
                                        )
                                    },
                                    error: function(){
                                        swal(
                                        'Terjadi kesalahan',
                                        'Segera hubungi Admin!',
                                        'error'
                                        )
                                    }
                                });
                       
                    });
                });
            },
        });
    }

function popupKaryawanAuditor() {
    var myHeading = "<p>Popup Karyawan AUDITOR</p>";
    $("#auditorModalLabel").html(myHeading);
    var url = "{{ route('datatables.popupKaryawanAuditor', '%%') }}";
    var lookAuditor = $('#lookupAuditor').DataTable({
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
                var rowData = lookAuditor.rows(rows).data();
                $.each($(rowData),function(key,value){
                    var kd_td = document.getElementById('select-td').value.trim();
                    var url = "{{ route('auditors.add_review_auditor') }}";
                    var token = document.getElementsByName('_token')[0].value.trim();
                    var jumlah_auditee = document.getElementById('re_auditee').rows[0].cells.length;
                        var jumlah_auditor = document.getElementById('re_auditor').rows[0].cells.length;
                        var total = jumlah_auditee + jumlah_auditor -2;
                        
                        if (total != 0){
                        for (i = 0; i < total; i++){
                            var cek_npk = document.getElementById('reviewby' + (i + 1));
                            if(value["npk"] == cek_npk.value){
                                swal(
                                'Error',
                                'NPK ' + cek_npk.value + ' sudah terdaftar dalam daftar review!',
                                'error'
                                )
                                return;
                            }
                        }
                    }
                    $('#auditorModal').modal('hide');
                    $.ajax({
                        url      : url,
                        type     : 'POST',
                        dataType : 'json',
                        data     : {
                            kd_td : kd_td,
                            npk : value["npk"],
                            _token : token,
                        },
                        success: function( _response ){
                            console.log(_response);
                            select_td();
                            swal(
                            'Sukses',
                            'Berhasil menambahkan review',
                            'success'
                            )
                        },
                        error: function(){
                            swal(
                            'Terjadi kesalahan',
                            'Segera hubungi Admin!',
                            'error'
                            )
                        }
                    });
                });
            });
        },
    });
}

function npkInfo(ths) {
    var nama = $('#'+ths).attr('namakar');
    var dep = $('#'+ths).attr('depkar');
    swal({
        title: 'Info NPK',
        text: nama + ' / ' + dep,
        type: 'info',
        animation: false
        })
}

</script>

@endsection
