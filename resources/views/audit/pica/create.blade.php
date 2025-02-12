@extends('layouts.app')
@section('content')

<style>

td, th {
    padding: 8px 10px 8px 0px;;
}

.tabledetail > thead > tr > th, .tabledetail > tbody > tr > th, .tabledetail > tfoot > tr > th, .tabledetail > thead > tr > td, .tabledetail > tbody > tr > td, .tabledetail > tfoot > tr > td {
    border: 1px solid #130d0d;
}

.bubble{
    background-color: #f2f2f2;
    color:black;
    padding: 8px;
    /* box-shadow: 0px 0px 15px -5px gray; */
    /* border-radius: 10px 10px 0px 0px; */
}

.bubble-content{
    background-color: #fff;
    padding: 10px;
    margin-top: -5px;
    /* border-radius: 0px 10px 10px 10px; */
    /* box-shadow: 2px 2px #dfdfdf; */
    box-shadow: 0px 0px 10px -5px gray;
    margin-bottom:10px;
}

textarea{
    resize:none;
}

input.tgl{
    padding-top: 0px !important; 
}

.select2-container--default .select2-results__option[aria-disabled=true] {
     display: none;
     }



</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>PICA Audit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">PICA Audit</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form PICA Audit</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('audit.pica._form')
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

@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $(".select2").select2();
    $("#kd_dep").children('option').prop('disabled', true);
    $("#kd_sie").children('option').prop('disabled', true); 
      $("#kd_dep").select2({
            placeholder: "SEMUA DEPARTEMEN",
        });

        $("#kd_div").select2({
            placeholder: "SEMUA DIVISI",
        });

        $("#kd_sie").select2({
            placeholder: "SEMUA SEKSI",
        });

        $("#periode").select2({
            placeholder: "SEMUA PERIODE",
        });

    $("#kd_div").change(function() {
        $("#kd_dep").children('option').prop('disabled', true);
        $("#kd_dep").children("option[value^='all']").prop('disabled', false);
        $("#kd_dep").children("option[value^=" + $(this).val() + "]").prop('disabled', false);
    
        $("#kd_dep").select2({
            placeholder: "SEMUA DEPARTEMEN",
        });
        $("#kd_sie").select2({
            placeholder: "SEMUA SEKSI",
        });
        $("#kd_dep").val('').trigger('change');
        $("#kd_sie").val('').trigger('change');
    });

    $("#kd_dep").change(function() {
        $("#kd_sie").children('option').prop('disabled', true);
        $("#kd_sie").children("option[value^='all']").prop('disabled', false);
        $("#kd_sie").children("option[value^=" + $(this).val() + "]").prop('disabled', false);
        $("#kd_sie").select2({
            placeholder: "SEMUA SEKSI",
        });
        $("#kd_sie").val('').trigger('change');
    });
      
});

var pica_id = document.getElementById('pica_id').value.trim();
var kd_div = 'all';
var kd_dep = 'all';
var kd_sie = 'all';
var url_tbl1 = "{{ route('auditors.picadaftarinput_by_filter', ['param', 'param2', 'param3', 'param4'])}}"
url_tbl1 = url_tbl1.replace('param', pica_id)
url_tbl1 = url_tbl1.replace('param2', kd_div)
url_tbl1 = url_tbl1.replace('param3', kd_dep)
url_tbl1 = url_tbl1.replace('param4', kd_sie)

$('#display_filter').click(function(){
    kd_div = document.getElementById('kd_div').value;
    kd_dep = document.getElementById('kd_dep').value;
    kd_sie = document.getElementById('kd_sie').value;
    if (kd_div == '' || kd_div == null ){
        swal(
            'Perhatian!',
            'Sebelum filter, lengkapi Divisi -> Departemen -> Seksi!',
            'info'
            )   
    } else {
    filter_url_tbl1 = "{{ route('auditors.picadaftarinput_by_filter', ['param', 'param2', 'param3', 'param4'])}}"
    if (kd_dep == null || kd_dep == ''){
        kd_dep = 'all';
    } 
    if (kd_sie == null || kd_sie == ''){
        kd_sie = 'all';
    }
    filter_url_tbl1 = filter_url_tbl1.replace('param', pica_id)
    filter_url_tbl1 = filter_url_tbl1.replace('param2', kd_div)
    filter_url_tbl1 = filter_url_tbl1.replace('param3', kd_dep)
    filter_url_tbl1 = filter_url_tbl1.replace('param4', kd_sie)
    table.ajax.url(filter_url_tbl1).load(function(){
        table.column(1).search($('#periode').val()).draw();
    });
    }
    });

    $('#periode').on('change', function(){
        table.column(1).search(this.value).draw();   
    });

$('#show_all').click(function(){
    $("#kd_div").val('').trigger('change');
    $("#kd_dep").val('').trigger('change');
    $("#kd_sie").val('').trigger('change');
    $("#periode").val('').trigger('change');

    table.ajax.url(url_tbl1).load();
});

var table = $('#daftartemuan').DataTable({
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 10,
    responsive: true,
    "searching": true,
    "paging": true,
    // "order": [2, 'asc']
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    // serverSide: true,
    ajax: url_tbl1,
    columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', searchable:false, orderable:false},
        {data: 'pica_no', name: 'pica_no'},
        {data: 'desc_div', name: 'desc.div'},
        {data: 'status', name: 'status'},
        ],
    "language": {
      "emptyTable": "Temuan audit sudah dipilih!"
    },
  });

  var table2 = $('#daftarpica').DataTable({
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 10,
    responsive: true,
    "searching": true,
    "paging": true,
    // "order": [2, 'asc']
    // processing: true, 
    // "oLanguage": {
    //   'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    // }, 
    // // serverSide: true,
    ajax: "#",
    columns: [
        {data: 'pica_no', name: 'pica_no', orderable:false},
        {data: 'action', name: 'action', orderable:false},
        ],
    "language": {
      "emptyTable": "Temuan audit belum dipilih, klik <button onclick='scrollToForm()' class='btn btn-success btn-sm'>PILIH TEMUAN AUDIT</button>"
    },
    "dom": 'rt'
  });

var condition = 1;
function scrollToForm(){
    if (condition == 1){
        $(".collapse").collapse('show');
        $('html, body').animate({
            scrollTop: $("#daftarpica").offset().top + 95
        }, 500);
        condition++;
    } else if(condition == 2){
        $(".collapse").collapse('hide');
        $('html, body').animate({
            scrollTop: $("body").offset().top
        }, 500);
        condition = 1;
    }
}
   

  function select(ths){
    var url = "{{ route('auditors.picadaftarinput_byid', 'param') }}";
    swal({
        title: 'Loading',
        text: 'Sedang memuat data...',
        showConfirmButton: false,
        animation: false 
    })
    url = url.replace('param', ths)
    $.ajax({
    type: 'GET', //THIS NEEDS TO BE GET
    url: url,
    success: function (data) {
        swal.close();
        document.getElementById('finding_no').innerHTML = data[0]["finding_no"];
        document.getElementById('finding').value = data[0]["finding_no"];
        document.getElementById('finding_id').innerHTML = data[0]["id"];
        document.getElementById('class').innerHTML = data[0]["cat"];
        document.getElementById('soc').innerHTML = data[0]["statement_of_nc"];
        document.getElementById('dop').innerHTML = data[0]["detail_problem"];
        $('html, body').animate({
            scrollTop: $("body").offset().top
        }, 500);
        $('#selector_audit').hide();
        $('#pica_title').hide();
        $('#added_pica').hide();
        $('#header_form').hide();        
        $('#back_btn').show();
        $('#part1').show();
        // for (i = 0; i < total_containment; i++){
        $('#containment_container').append('\
        <div id="containment_item" style="margin-bottom:8px;">\
            <label class="bubble">CONT. OF ACTION &nbsp;<small style="display:inline-flex;"><div id="info_coa">1&nbsp;&nbsp;</div>of&nbsp;&nbsp;'+ data[1].length +'</small></label>\
            <button type="button" id="prev_coa" style="margin-left: 10px;margin-bottom: 4px;cursor: pointer;line-height: 1.3;" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>\
            <button type="button" id="next_coa" style="margin-bottom: 4px;line-height: 1.3;cursor: pointer;" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>\
            <div style="height:200px;overflow-y:scroll;" class="bubble-content">\
            <div id="coa" name="coa">'+data[1][0]["containment_of_action"]+'</div>\
            <label>PIC</label>\
            <input class="form-control" id="pic" name="pic" value="'+data[1][0]["pic"]+'" readonly>\
            <label>DUE DATE</label>\
            <input class="form-control" id="due_date" name="due_date" value="'+data[1][0]["due_date"]+'" readonly>\
        </div>\
        ');
        
        var count = data[1].length;
        var current = 0;
        if (count == 1){
            document.getElementById('next_coa').disabled = true;
        }
        document.getElementById('prev_coa').disabled = true;
        $('#next_coa').click(function(){
            current++;
            document.getElementById('info_coa').innerHTML = (current + 1) + '&nbsp;&nbsp;';
            document.getElementById('prev_coa').disabled = false;
            document.getElementById('coa').innerHTML = '{!! str_replace("'+\n+'","<br>", "'+data[1][current]['containment_of_action']+'") !!}';
            document.getElementById('pic').value = data[1][current]["pic"];
            document.getElementById('due_date').value = data[1][current]["due_date"];
            if ((current + 1) == count){
                document.getElementById('next_coa').disabled = true;
            }
        });
        $('#prev_coa').click(function(){
            current--;
            document.getElementById('info_coa').innerHTML = current + 1 + '&nbsp;&nbsp;';
            document.getElementById('next_coa').disabled = false;
            document.getElementById('coa').innerHTML = '{!! str_replace("'+\n+'","<br>", "'+data[1][current]['containment_of_action']+'") !!}';
            document.getElementById('pic').value = data[1][current]["pic"];
            document.getElementById('due_date').value = data[1][current]["due_date"];
            if ((current + 1) == 1){
                document.getElementById('prev_coa').disabled = true;
            }
        });
        // }
    },        

    error: function() { 
         console.log();
    }
});
  }

  $('#back_btn').click(function(){
    $('#selector_audit').show();
    $('#pica_title').show();
    $('#added_pica').show();
    $('#header_form').show();
    $('#back_btn').hide();
    $('#part1').hide();
    $('#containment_item').remove();
    $('html, body').animate({
            scrollTop: $("#daftarpica").offset().top + 95
        }, 500);
  });

// FORM bagian Corrective & Preventive Action
    var number = 1;
    var count = 1;
    $('#prev_corrective').attr('disabled', true);
    $('#next_corrective').attr('disabled', true);
    $('#add_corrective').click(function(){
        number++;
        count++;
        $('#prev_corrective').attr('disabled', false);
        $('#corrective_row').append('\
        <div class="no_corrective" id="no_corrective_'+count+'">\
        <label>Data '+count+'</label>\
        <textarea rows="4" name="ca[]" class="form-control"></textarea>\
        <label>PIC</label>\
        <input class="form-control" id="pic" name="pic_containment[]">\
        <label>DUE DATE</label>\
        <input type="date" class="form-control" id="due_date" name="due_date_containment[]">\
        </div>\
        ');
        $('.no_corrective').hide();
        $('#no_corrective_'+count).show();
        $('#next_corrective').attr('disabled', true);
        $('#prev_corrective').attr('disabled', false);

        number = count;
    });

    $('#prev_corrective').click(function(){
        number--;
        if (number == 1){
            $('#prev_corrective').attr('disabled', true);
            $('#next_corrective').attr('disabled', false);
        } else {
            $('#next_corrective').attr('disabled', false);
            $('#prev_corrective').attr('disabled', false);
        }
        $('#no_corrective_'+number).show(function(){
            $('.no_corrective').not('#no_corrective_'+number).hide(function(){   
            });
        });
    });

    $('#next_corrective').click(function(){
        number++;
        if (number == count){
            $('#next_corrective').attr('disabled', true);
            $('#prev_corrective').attr('disabled', false);
        } else {
            $('#next_corrective').attr('disabled', false);
            $('#prev_corrective').attr('disabled', false);
        }
        $('#no_corrective_'+number).show(function(){
            $('.no_corrective').not('#no_corrective_'+number).hide(function(){   
            });
        });
    });

// == FORM bagian Corrective & Preventive Action == 

// FORM bagian Yokoten
    var number2 = 1;
    var count2 = 1;
    $('#prev_yokoten').attr('disabled', true);
    $('#next_yokoten').attr('disabled', true);
    $('#add_yokoten').click(function(){
        number2++;
        count2++;
        $('#prev_yokoten').attr('disabled', false);
        $('#yokoten_row').append('\
        <div class="no_yokoten" id="no_yokoten_'+count2+'">\
        <label>Data '+count2+'</label>\
        <textarea rows="4" name="ya[]" class="form-control"></textarea>\
        <label>PIC</label>\
        <input class="form-control" id="pic" name="pic_yokoten[]">\
        <label>DUE DATE</label>\
        <input type="date" class="form-control" id="due_date" name="due_date_yokoten[]">\
        </div>\
        ');
        $('.no_yokoten').hide();
        $('#no_yokoten_'+count2).show();
        $('#next_yokoten').attr('disabled', true);
        $('#prev_yokoten').attr('disabled', false);

        number2 = count2;
    });

    $('#prev_yokoten').click(function(){
        number2--;
        if (number2 == 1){
            $('#prev_yokoten').attr('disabled', true);
            $('#next_yokoten').attr('disabled', false);
        } else {
            $('#next_yokoten').attr('disabled', false);
            $('#prev_yokoten').attr('disabled', false);
        }
        $('#no_yokoten_'+number2).show(function(){
            $('.no_yokoten').not('#no_yokoten_'+number2).hide(function(){   
            });
        });
    });

    $('#next_yokoten').click(function(){
        number2++;
        if (number2 == count2){
            $('#next_yokoten').attr('disabled', true);
            $('#prev_yokoten').attr('disabled', false);
        } else {
            $('#next_yokoten').attr('disabled', false);
            $('#prev_yokoten').attr('disabled', false);
        }
        $('#no_yokoten_'+number2).show(function(){
            $('.no_yokoten').not('#no_yokoten_'+number2).hide(function(){   
            });
        });
    });

// == FORM bagian Corrective & Preventive Action == 

$('#form_id').on('submit', function(event){
    event.preventDefault();
    var pica_no = document.getElementById('pica_id').value.trim();
    var finding_no = document.getElementById('finding_no').innerHTML;   
    var finding_id = document.getElementById('finding_id').innerHTML;
    var url = "{{ route('auditors.picadaftarinput_byid_add', ['param', 'param2']) }}";
    url = url.replace('param', pica_no);
    url = url.replace('param2', finding_id);

            swal({
            title: 'Konfirmasi?',
            text: 'Simpan PICA Temuan?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Cek kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : $('#form_id').serialize(),
                success: function( _response ){
                    swal(
                        'Sukses',
                        'Berhasil disimpan!',
                        'success'
                        ).then(function (){
                            $(".btn").prop("disabled", true);                
                            // Simulate an HTTP redirect:
                            $('html, body').animate({
                                scrollTop: $("body").offset().top
                            }, 500);
                            location.reload();
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
                })
});

function open_edit(ths){
    url = "{{ route('auditors.edit_pica', 'id') }}";
    url = url.replace('id', ths.substring(1));
    location.href = url;
}

function open_detail(ths){
    url = "{{ route('auditors.detail_pica', 'id') }}";
    url = url.replace('id', ths.substring(1));
    location.href = url;
}

function delete_item(ths){
    var pica_no = document.getElementById('pica_id').value.trim();
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.picadaftarinput_byid_delete') }}"
    swal({
            title:'HAPUS ITEM?',
            // text: 'H?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    finding_no : pica_no,
                    _token : token,
                },
                success: function( _response ){
                    table.ajax.reload();
                    table2.ajax.reload();
                    // document.getElementById("back_btn").click();
                    document.getElementById('pica_temuan').value = 'Temuan audit belum dipilih!';
                    document.getElementById('pica_dept').value = 'Temuan audit belum dipilih!';
                    document.getElementById('pica_auditor').value = 'Temuan audit belum dipilih!';
                    document.getElementById('pica_auditee').value = 'Temuan audit belum dipilih!';

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


var rca_no = 1;
function next_rca(ths){
    $('.why'+rca_no+ths).hide();
    rca_no++;
    $('.why'+rca_no+ths).show();
    if (rca_no == 5){
        $('#n'+ths).attr('disabled', true);
    } else {
        $('#n'+ths).attr('disabled', false);
        $('#p'+ths).attr('disabled', false);
    }
}

function prev_rca(ths){
    $('.why'+rca_no+ths).hide();
    rca_no--;
    $('.why'+rca_no+ths).show();
    if (rca_no == 1){
        $('#p'+ths).attr('disabled', true);   
    } else {
        $('#n'+ths).attr('disabled', false);
        $('#p'+ths).attr('disabled', false);
    }
}

var rca_count = 1;
function add_rca(){
    rca_count++;
    $('#rca_content').append('\
    <div id="content_'+rca_count+'">\
    <input type="hidden" id="analysis_no" name="analysis_no[]" value="'+rca_count+'">\
    <label style="background-color: #74bb7a;color:white;" class="bubble">ROOT CAUSE ANALYSIS</label>\
    <button id="d_'+rca_count+'" onclick="delete_rca((this.id).substring(2))" type="button" class="btn btn-danger btn-sm" style="margin-bottom: 5px;">Hapus</button>\
    <div class="bubble-content">\
                        <div id="title_root" style="text-align: center;font-weight: bold;font-size: 40px;">\
                            <select class="form-control input-lg" id="selector_title" name="analysis_type[]" style="width:150px;margin-left:40%;">\
                                <option value="METHOD">METHOD</option>\
                                <option value="MAN">MAN</option>\
                                <option value="MATERIAL">MATERIAL</option>\
                                <option value="MACHINE">MACHINE</option>\
                            </select>\
                            <button id="p_'+rca_count+'" onclick="prev_rca((this.id).substring(1))" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;float:left;" disabled><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>\
                            <button id="n_'+rca_count+'" onclick="next_rca((this.id).substring(1))" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;float:right;"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>\
                        </div>\
                        <table id="table_data" class="table-borderless" style="width:100%;">\
                            <tr class="why1_'+rca_count+'">\
                                <td rowspan="2"><label>Why 1</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                            </tr>\
                            <tr class="why1_'+rca_count+'">\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>\
                            </tr>\
                            <tr class="why2_'+rca_count+'" style="display:none;">\
                                <td rowspan="2"><label>Why 2</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                            </tr>\
                            <tr class="why2_'+rca_count+'" style="display:none;">\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]"></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                            </tr>\
                            <tr class="why3_'+rca_count+'" style="display:none;">\
                                <td rowspan="2"><label>Why 3</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                            </tr>\
                            <tr class="why3_'+rca_count+'" style="display:none;">\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]"></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                            </tr>\
                            <tr class="why4_'+rca_count+'" style="display:none;">\
                                <td rowspan="2"><label>Why 4</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                            </tr>\
                            <tr class="why4_'+rca_count+'" style="display:none;">\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]"></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                            </tr>\
                            <tr class="why5_'+rca_count+'" style="display:none;">\
                                <td rowspan="2"><label>Why 5</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                            </tr>\
                            <tr class="why5_'+rca_count+'" style="display:none;">\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]"></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>\
                            </tr>\
                        </table>\
                    </div>\
                    </div>\
    ');
}

function delete_rca(ths){
    $('#content_'+ths).remove();
}

function submit_pica(){
    var token = document.getElementsByName('_token')[0].value.trim();
    var pica_no = document.getElementById('pica_id').value.trim();
    var url = "{{ route('auditors.submit_pica', 'param') }}";
    url = url.replace('param', pica_no);
    swal({
            title:'SUBMIT PICA?',
            // text: 'H?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Submit',
            cancelButtonText: 'Back',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    _token : token,
                },
                success: function( _response ){
                    swal(
                        'Sukses',
                        'Berhasil disimpan!',
                        'success'
                        ).then(function (){
                            $(".btn").prop("disabled", true);                
                            // Simulate an HTTP redirect:
                            $('html, body').animate({
                                scrollTop: $("body").offset().top
                            }, 500);
                            window.location.href = "{{ route('auditors.daftar_pica')}}"
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
                })
}

$('.pic').click(function(){
    var thisid = $(this);
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
                thisid.val(value['npk'] + ' - ' + value['nama']);
                // document.getElementById('nama'+nama).innerHTML = value["nama"];
                // document.getElementById('listauditee').value += value["nama"] + ',  ';
                $('#karyawanModal').modal('hide');
            });
        });
        // $('#karyawanModal').on('hidden.bs.modal', function () {
        // });
    },
    });
}); 



</script>

@endsection
