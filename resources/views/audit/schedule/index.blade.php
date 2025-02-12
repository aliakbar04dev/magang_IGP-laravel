@extends('layouts.app')
@section('content')

<style>

.hoverTable{
    width:100%; 
    border-collapse:collapse; 
}
.hoverTable td{ 
    padding:7px;
}
/* Define the default color for all the table rows */
.hoverTable tr{
    background:white;
}
/* Define the hover highlight color for the table row */
.hoverTable tr:hover:not(.notHover) {
        background-color: #ffff99;
}

.notHover:hover {
    background-color:white;

}

td, th {
    padding: 8px 10px 8px 8px;;
}

.tabledetail > thead > tr > th, .tabledetail > tbody > tr > th, .tabledetail > tfoot > tr > th, .tabledetail > thead > tr > td, .tabledetail > tbody > tr > td, .tabledetail > tfoot > tr > td {
    border: 1px solid #130d0d;
}

.bubble{
    background-color: #74bb7a;
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
    background-color: white;
}

#item {
    cursor: grab;
}

#item.active {
    cursor: grabbing;
}

.select2-container--default .select2-results__option[aria-disabled=true] {
     display: none;
     }

/* .new {
    display:none;
}

.old {
    display:none;
} */


/* tr:nth-child(even) {
  background-color: #f2f2f2;
} */

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>Schedule Internal Audit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Schedule Internal Audit</li>
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
                        <h3 class="box-title">Schedule Internal Audit</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('audit.schedule._form')
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
    @include('audit.popup.auditee_schedule')
    <!-- Modal Auditor -->
    @include('audit.popup.auditorModal')

@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

$("#kd_dep").children('option').prop('disabled', true);
$("#kd_sie").children('option').prop('disabled', true);
    
const slider = document.querySelector('#item');
let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener('mousedown', (e) => {
  isDown = true;
  slider.classList.add('active');
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});
slider.addEventListener('mouseleave', () => {
  isDown = false;
  slider.classList.remove('active');
});
slider.addEventListener('mouseup', () => {
  isDown = false;
  slider.classList.remove('active');
});
slider.addEventListener('mousemove', (e) => {
  if(!isDown) return;
  e.preventDefault();
  const x = e.pageX - slider.offsetLeft;
  const walk = (x - startX) * 1; //scroll-fast
  slider.scrollLeft = scrollLeft - walk;
//   console.log(walk);
});

var click_show = 0;
$('#delete_schedule').click(function(){
    if (click_show == 0){
        $('.hapus_td').addClass('hapus_active');
        $('.hapus_td').removeClass('hapus_td');
        $('.hapus_btn').show();
        $('#delete_schedule').text('BATAL HAPUS');
        click_show = 1;
    } else {
        $('.hapus_active').addClass('hapus_td');
        $('.hapus_active').removeClass('hapus_active');
        $('.hapus_btn').hide();
        $('#delete_schedule').text('HAPUS JADWAL');
        click_show = 0;
    }
});

$('#update_jadwal').click(function(){
    if (click_show == 0){
        if (click_show2 == 1){
            $('#selesai_jadwal').trigger( "click" );    
        }
        $('.hapus_td').addClass('hapus_active');
        $('.hapus_td').removeClass('hapus_td');
        $('.reschedule').show();
        $('#update_jadwal').text('BATAL UPDATE');
        $('#update_jadwal').removeClass('bg-navy');
        $('#update_jadwal').addClass('btn-danger');

        click_show = 1;
    } else {
        $('.hapus_active').addClass('hapus_td');
        $('.hapus_active').removeClass('hapus_active');
        $('.reschedule').hide();
        $('#update_jadwal').text('RESCHEDULE');
        $('#update_jadwal').removeClass('btn-danger');
        $('#update_jadwal').addClass('bg-navy');
        click_show = 0;
    }
});




var click_show2 = 0;
$('#selesai_jadwal').click(function(){
    if (click_show2 == 0){
        if (click_show == 1){
            $('#update_jadwal').trigger( "click" );
        }
        $('.hapus_td').addClass('hapus_active');
        $('.hapus_td').removeClass('hapus_td');
        $('.selesai').show();
        $('#selesai_jadwal').text('BATAL UPDATE');
        $('#selesai_jadwal').removeClass('bg-navy');
        $('#selesai_jadwal').addClass('btn-danger');
        click_show2 = 1;
    } else {
        $('.hapus_active').addClass('hapus_td');
        $('.hapus_active').removeClass('hapus_active');
        $('.selesai').hide();
        $('#selesai_jadwal').text('SELESAIKAN JADWAL');
        $('#selesai_jadwal').removeClass('btn-danger');
        $('#selesai_jadwal').addClass('bg-navy');
        click_show2 = 0;
    }
});


$('#add_schedule').click(function(){
    $('#head_sec').hide();
    $('#table_sec').hide();
    $('#submit_btn').hide();
    $('#submit_add_schedule').show();
    $('#back_btn').show();
    $('#add_sec').show();
    if (click_show == 1){
        $('#delete_schedule').trigger('click');
    }
    $('#jenis_schedule').val('1');
    $('#jenis_schedule').trigger('change');

});

$('#back_btn').click(function(){
    $('#head_sec').show();
    $('#table_sec').show();
    $('#submit_btn').show();
    $('#submit_add_schedule').hide();
    $('#back_btn').hide();
    $('#add_sec').hide();
});

$("#kd_dep").select2({
            placeholder: "PILIH DEPARTEMEN",
        });

        $("#kd_div").select2({
            placeholder: "PILIH DIVISI",
        });

        $("#kd_sie").select2({
            placeholder: "PILIH SEKSI",
        });

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

    $("#tahun_select").change(function() {
    var periode = $("#periode_select").val();
    $("#revisi_select").val('00');
    $("#revisi_select").children('option').hide();
    $("#revisi_select").children('option').prop('disabled', true);
    $("#revisi_select").children("option[tahun=" + $(this).val() + periode + "]").show();
    $("#revisi_select").children("option[tahun=" + $(this).val() + periode + "]").prop('disabled', false);

    });

    $("#periode_select").change(function() {
        var tahun = $("#tahun_select").val();
        $("#revisi_select").val('00');
        $("#revisi_select").children('option').hide();
        $("#revisi_select").children('option').prop('disabled', true);
        $("#revisi_select").children("option[tahun=" + tahun + $(this).val() + "]").show();
        $("#revisi_select").children("option[tahun=" + tahun + $(this).val() + "]").prop('disabled', false);

    });

    // $("#periode_select").ready(function() {
    
    // $("#revisi_select").children('option').hide();
    // $("#revisi_select").children('option').prop('disabled', true);
    // $("#revisi_select").children("option[periode=" + "{{ $data_schedule->first()->periode }}" + "]", "option[tahun=" + "{{ $data_schedule->first()->tahun }}" + "]").show();
    // $("#revisi_select").children("option[periode=" + "{{ $data_schedule->first()->periode }}" + "]", "option[tahun=" + "{{ $data_schedule->first()->tahun }}" + "]").prop('disabled', false);
    
    // });

    $("#tahun_select").ready(function() {
    
    $("#revisi_select").children('option').hide();
    $("#revisi_select").children('option').prop('disabled', true);
    $("#revisi_select").children("option[tahun=" + "{{ $data_schedule->first()->tahun . $data_schedule->first()->periode }}" + "]").show();
    $("#revisi_select").children("option[tahun=" + "{{ $data_schedule->first()->tahun . $data_schedule->first()->periode }}" + "]").prop('disabled', false);
    
    });


$('#display_filter').click(function(){
    var tahun_filter = $('#tahun_select :selected').val();
    var periode_filter = $('#periode_select :selected').val();
    var revisi_filter = $('#revisi_select :selected').val();
    var url_filter = "{{ route('auditors.schedule', [$data_schedule->first()->plant, 'param1', 'param2', 'param3']) }}"
    url_filter = url_filter.replace('param1', tahun_filter);
    url_filter = url_filter.replace('param2', periode_filter);
    url_filter = url_filter.replace('param3', revisi_filter);
    location.href = url_filter;
});

    $('.hapus_btn').click(function(){
        var id = $(this).attr('id');
        var schedule_id = document.getElementById('schedule_id').value;
        var token = document.getElementsByName('_token')[0].value.trim();
        var url = "{{ route('auditors.schedule_hapus') }}";
        swal({
            title: 'Hapus jadwal?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    id   : schedule_id,
                    id2 : id,
                    _token  : token
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                        swal(
                        'Sukses',
                        'Berhasil menghapus jadwal!',
                        'success'
                        )
                        location.reload();
                    } else if (_response.indicator == '0') {
                        $( "#delete_schedule" ).trigger( "click" );
                        swal(
                        'Info',
                        'Gagal menghapus jadwal! Hubungi Admin',
                        'info'
                        )
                        $(".btn").attr("disabled", false); 
                    }
                },
                error: function(){
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

$("#item").on('mousedown', function(){
    if (click_show == 0 || !$("#head_sec").is(":visible")){
        return false;
    } else {
        return true;
    }
});

$('#select_date').datepicker({
    format : 'dd/mm/yyyy',
    daysOfWeekDisabled: [0,6],
    autoclose: true
}).on("click", function(){
    // $(this).val("01");
}); 

$('.re_datepicker').datepicker({
    format : 'dd/mm/yyyy',
    daysOfWeekDisabled: [0,6],
    autoclose: true
}).on("click", function(){
    // $(this).val("01");
});

// $('.datepicker').click(function(){
//     $('.prev').hide();
//     $('.next').hide();
//     $('.old').text('');
//     $('.new').text('');
//     $('.old').removeClass('day');
//     $('.new').removeClass('day');
//     $('.datepicker-switch').addClass('month-info');
//     $('.datepicker-switch').removeClass('datepicker-switch');
// });

$('.re_datepicker').click(function(){
    $('.prev').hide();
    $('.next').hide();
    $('.old').text('');
    $('.new').text('');
    $('.old').removeClass('day');
    $('.new').removeClass('day');
    $('.datepicker-switch').addClass('month-info');
    $('.datepicker-switch').removeClass('datepicker-switch');
});

$('.re_datepicker').change(function(){
    var val_tgl = $(this).val();
    // $(this).val(val_tgl.substring(0, 2));
});

$('#select_date').change(function(){
    var val_tgl = $(this).val();
    // $(this).val(val_tgl.substring(0, 2));
});

$('#tambah_auditee').click(function(){
    row_auditee++;
    $('#tblAuditee').append('<tr id="row_auditee'+row_auditee+'">\
        <td><input type="hidden" id="npkaud'+row_auditee+'" name="auditee[]"><input id="auditee'+row_auditee+'" class="form-control" onclick="popupAuditee(this.id)" data-toggle="modal" data-target="#karyawanModal" style="background-color: white;" required onkeydown="return false;"></td>\
        <td><button onclick="hapus_row_auditee(this.id)" id="hpss'+ row_auditee +'" class="btn btn-danger"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></td>\
        </tr>')
});

$('#tambah_auditor').click(function(){
    row_auditor++;
    $('#tblAuditor').append('<tr id="row_auditor'+ row_auditor +'">\
        <td><input type="hidden" id="npkauditor'+ row_auditor +'" name="auditor[]"><input id="auditor'+row_auditor+'" class="form-control" onclick="popupKaryawanAuditor2(this.id)" data-toggle="modal" data-target="#auditorModal" style="background-color: white;" required onkeydown="return false;"></td>\
        <td><button onclick="hapus_row_auditor(this.id)" id="hps'+ row_auditor +'" class="btn btn-danger"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></td>\
        </tr>')
});

$('#jenis_schedule').change(function(){
    
});

$('#form_new_schedule').on('submit', function(e){
    e.preventDefault();
    var url = "{{ route('auditors.submit_new_schedule') }}";
        swal({
            title: 'Tambahkan jadwal?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tambah',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : $('#form_new_schedule').serialize(),
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Berhasil menambahkan jadwal!',
                        'success'
                        )
                        location.reload();
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal menambah jadwal! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                } else if (_response.indicator == '3') {
                    swal(
                        'Info',
                        'Bagian tersebut sudah dibuatkan schedule!',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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

});

$('#submit_btn').click(function(){
    var url = "{{ route('auditors.simpan_schedule') }}";
    var bulan_now = "{{ \Carbon\Carbon::now()->format('m') }}";
    var tahun_now = "{{ \Carbon\Carbon::now()->format('Y') }}";
    var token = document.getElementsByName('_token')[0].value.trim();
    var schedule_id = document.getElementById('schedule_id').value;
    
        swal({
            title: 'Simpan dan setujui jadwal?',
            text: 'Jika ada perubahan, maka akan dibuatkan revisi baru',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    id : schedule_id,
                    _token : token
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Berhasil menyimpan jadwal!',
                        'success'
                        )
                        location.reload();
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal menyimpan jadwal! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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

    
});

$('#jenis_schedule').change(function(){
    if ($(this).val() == "2") {
        $('.add_sec_sub').hide();
        $('#submit_add_schedule').hide();
        $('#opening_add_schedule').show();
        $('#closing_add_schedule').hide();
    } else if ($(this).val() == "3"){
        $('.add_sec_sub').hide();
        $('#submit_add_schedule').hide();
        $('#opening_add_schedule').hide();
        $('#closing_add_schedule').show();
    } else {
        $('.add_sec_sub').show();
        $('#submit_add_schedule').show();
        $('#opening_add_schedule').hide();
        $('#closing_add_schedule').hide();
    }
});

$('#opening_add_schedule').click(function(){
    var token = document.getElementsByName('_token')[0].value.trim();
    var schedule_type = $('#jenis_schedule').val();
    var schedule_id = document.getElementById('schedule_id').value;
    var keterangan = $('#keterangan_id').val();
    var tanggal = $('#select_date').val();
    var tahun_val = document.getElementById('tahun_val').value;
    var periode_val = document.getElementById('periode_val').value;
    var rev_no_val = document.getElementById('rev_no_val').value;
    var url = "{{ route('auditors.submit_new_schedule_all', 'param') }}";
    url = url.replace('param', schedule_type);
    if (tanggal == '' || tanggal == null){
        swal(
            'Info',
            'Input tanggal masih kosong!',
            'info'
            )
    } else {
        swal({
            title: 'Tambahkan jadwal opening?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tambah',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    schedule_id : schedule_id,
                    type : schedule_type,
                    tanggal : tanggal,
                    tahun : tahun_val,
                    periode : periode_val,
                    rev_no : rev_no_val,
                    keterangan : keterangan,
                    _token : token,
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Berhasil menambahkan jadwal!',
                        'success'
                        )
                        location.reload();
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal menambah jadwal! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                } else if (_response.indicator == '3') {
                    swal(
                        'Info',
                        'Bagian tersebut sudah dibuatkan schedule!',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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
});

$('#closing_add_schedule').click(function(){
    var token = document.getElementsByName('_token')[0].value.trim();
    var schedule_type = $('#jenis_schedule').val();
    var schedule_id = document.getElementById('schedule_id').value;
    var keterangan = $('#keterangan_id').val();
    var tanggal = $('#select_date').val();
    var tahun_val = document.getElementById('tahun_val').value;
    var periode_val = document.getElementById('periode_val').value;
    var rev_no_val = document.getElementById('rev_no_val').value;
    var url = "{{ route('auditors.submit_new_schedule_all', 'param') }}";
    url = url.replace('param', schedule_type);
    if (tanggal == '' || tanggal == null){
        swal(
            'Info',
            'Input tanggal masih kosong!',
            'info'
            )
    } else {
        swal({
            title: 'Tambahkan jadwal closing?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tambah',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    schedule_id : schedule_id,
                    type : schedule_type,
                    tanggal : tanggal,
                    tahun : tahun_val,
                    periode : periode_val,
                    rev_no : rev_no_val,
                    keterangan : keterangan,
                    _token : token,
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Berhasil menambahkan jadwal!',
                        'success'
                        )
                        location.reload();
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal menambah jadwal! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                } else if (_response.indicator == '3') {
                    swal(
                        'Info',
                        'Bagian tersebut sudah dibuatkan schedule!',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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
});

$('#revisi').click(function(){
    var url = "{{ route('auditors.revisi_schedule') }}";
    var token = document.getElementsByName('_token')[0].value.trim();
    var schedule_id = document.getElementById('schedule_id').value;
    var tahun_val = document.getElementById('tahun_val').value;
    var periode_val = document.getElementById('periode_val').value;
    var rev_no_val = document.getElementById('rev_no_val').value;
    var plant_val = "{{ $data_schedule->first()->plant }}";
    var url_redirect = "{{ route('auditors.schedule', ['param', 'param2', 'param3', 'latest']) }}";
    url_redirect = url_redirect.replace('param', plant_val);
    url_redirect = url_redirect.replace('param2', tahun_val);
    url_redirect = url_redirect.replace('param3', periode_val);

    swal({
            title: 'Buatkan revisi untuk Schedule ini?',
            text: 'Revisi akan otomatis berbentuk draft. Schedule lama akan tetap aktif sebelum revisi disimpan dan diresmikan',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, revisi dan update',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    id : schedule_id,
                    tahun : tahun_val,
                    // bulan : bulan_val,
                    periode : periode_val,
                    rev_no : rev_no_val,
                    plant : plant_val,
                    _token : token
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Info',
                        'Anda sedang dialihkan ke halaman revisi!',
                        'info'
                        )
                        location.href = url_redirect;
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal menyimpan jadwal! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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
            });

$('#hapus_draft').click(function(){
    var token = document.getElementsByName('_token')[0].value.trim();
    var schedule_id = document.getElementById('schedule_id').value;
    var tahun_val = document.getElementById('tahun_val').value;
    var periode_val = document.getElementById('periode_val').value;
    var rev_no_val = document.getElementById('rev_no_val').value;
    var plant_val = "{{ $data_schedule->first()->plant }}";
    var url = "{{ route('auditors.hapus_draft_schedule', 'param') }}"
    var url_redirect = "{{ route('auditors.schedule', ['param', 'param2', 'param3', 'latest']) }}";
    url_redirect = url_redirect.replace('param', plant_val);
    url_redirect = url_redirect.replace('param2', tahun_val);
    url_redirect = url_redirect.replace('param3', periode_val);
    url = url.replace('param', schedule_id);
    swal({
            title: 'Hapus draft schedule ini?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    id : schedule_id,
                    tahun : tahun_val,
                    periode : periode_val,
                    plant : plant_val,
                    rev_no : rev_no_val,
                    _token : token
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Berhasil menghapus draft!',
                        'success'
                        )
                        location.href = url_redirect;
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal menghapus draft! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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
});

$('.selesai_btn').click(function(){
    var id = $(this).attr('id');
    var schedule_id = document.getElementById('schedule_id').value;
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.selesai_jadwal') }}";
        swal({
            title: 'Selesaikan jadwal?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, selesaikan',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    id   : id,
                    _token  : token
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Jadwal schedule berhasil diselesaikan!',
                        'success'
                        )
                        location.reload();
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal menyelesaikan jadwal! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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
});

$('.reschedule_btn').click(function(){
    var id2 = $(this).attr("id").substr(6);
    var tgl_after = $("#input_re"+id2).val();
    var schedule_id = document.getElementById('schedule_id').value;
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.reschedule') }}";

    if (tgl_after == null || tgl_after == ''){
        swal(
        'Info',
        'Pilih tanggal reschedule!',
        'info'
        )
    } else {

        swal({
            title: 'Reschedule jadwal?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                        id   : id2,
                        tgl_after : tgl_after,
                    _token  : token
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Jadwal schedule berhasil diubah!',
                        'success'
                        )
                        location.reload();
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal mengubah jadwal! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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
});

$('.batal_btn').click(function(){
    var id2 = $(this).attr("id").substr(6);
    var tgl_after = $("#input_re"+id2).val();
    var schedule_id = $("#schedule_id").val();
    // var rev_no_val = document.getElementById('rev_no_val').value; 
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.batal_dan_reschedule') }}";
        swal({
            title: 'Reschedule jadwal ini?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Reschedule',
            cancelButtonText: 'Kembali',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
            // html: '<button onclick="batal_swal()" class="btn btn-danger swal2-batal" style="line-height: 1.7;" onclick="swal.close();">KEMBALI</button>',
            // onOpen: function(swal){
            //     $(swal).find('.swal2-batal').off().click(function(e) {
            //         // $(swal).find('.swal2-cancel').trigger('click');
            //         // $('.swal2-container').remove();
            //         $('.swal2-container').trigger( "click" );
            //     });
            // }
        }).then(function () {
            // $(".btn").attr("disabled", true);
            swal({
                title: 'Pilih tanggal untuk reschedule',
                html: "<input class='form-control re_datepicker tgl_next_month_picker' placeholder='Klik untuk memilih tanggal...' readonly><p id='info_empty' style='color:red;display:none;'>Tanggal belum diinput!</p>",
                showCancelButton: true,
                animation: true,
                confirmButtonText: 'Reschedule',
                onOpen : function (swal){
                    $('.re_datepicker').datepicker({
                        format : 'dd/mm/yyyy',
                        daysOfWeekDisabled: [0,6],
                        autoclose: true
                    }).on("click", function(){
                        // $(this).val("01");
                    }); 
                    $('.re_datepicker').click(function(){
                    $('.datepicker-switch').addClass('month-info');
                });
                }
            }).then(function (){
                var tgl_input = $(".tgl_next_month_picker").val();
                var tahun_val = tgl_input.substring(6);
                var bulan_val = tgl_input.substring(3, 5);
                var tgl_val = tgl_input.substring(0, 2);
                var plant_val = "{{ $data_schedule->first()->plant }}";
                var periode_val = "{{ $data_schedule->first()->periode }}";
                var rev_no_val = "{{ $data_schedule->first()->rev_no }}";
                var url_redirect = "{{ route('auditors.schedule', ['param', 'param2', 'param3', 'latest']) }}";
                url_redirect = url_redirect.replace('param', plant_val);
                url_redirect = url_redirect.replace('param2', tahun_val);
                url_redirect = url_redirect.replace('param3', periode_val);
                if (tgl_input != ''){
                $.ajax({
                url      : url,

                type     : 'POST',
                dataType : 'json',
                data     : {
                    id   : id2,
                    tgl : tgl_val,
                    tahun : tahun_val,
                    rev_no : rev_no_val,
                    bulan : bulan_val,
                    periode : periode_val,
                    plant : plant_val,
                    _token  : token
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Jadwal schedule berhasil diubah!',
                        'success'
                        )
                        location.href = url_redirect;
                        // location.reload();
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal mengubah jadwal! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
                    },
                    error: function(){
                        swal(
                            'Terjadi kesalahan',
                            'Segera hubungi Admin!',
                            'error'
                            )
                        }
                    });
                } else {
                    swal(
                        'Info',
                        'Tanggal input kosong, perhatikan inputan anda!!',
                        'info'
                        )
                }
            })      
                }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
                var url = "{{ route('auditors.batal_schedule') }}";
                // $.ajax({
                // url      : url,
                // type     : 'POST',
                // dataType : 'json',
                // data     : {
                //         id   : id2,
                //         tgl_after : tgl_after,
                //     _token  : token
                // },
                // success: function( _response ){
                //     console.log(_response.indicator);
                //     if(_response.indicator == '1'){
                //     swal(
                //         'Sukses',
                //         'Jadwal berhasil dibatalkan!',
                //         'success'
                //         )
                //         location.reload();
                // } else if (_response.indicator == '0') {
                //     $( "#delete_schedule" ).trigger( "click" );
                //     swal(
                //         'Info',
                //         'Gagal membatalkan jadwal! Hubungi Admin',
                //         'info'
                //         )
                //     $(".btn").attr("disabled", false); 
                // }
                //     },
                //     error: function(){
                //         swal(
                //             'Terjadi kesalahan',
                //             'Segera hubungi Admin!',
                //             'error'
                //             )
                //         }
                //     });
            }
            
        })
});

});

$('.ket_edit_btn').click(function(){
    var id2 = $(this).attr("id").substr(7);
    var tgl_after = $("#input_re"+id2).val();
    var schedule_id = $("#schedule_id").val();
    var token = document.getElementsByName('_token')[0].value.trim();
    var get_current_keterangan = $('#keterangan_'+id2).text();
    var url = "{{ route('auditors.edit_keterangan') }}";
        swal({
            title: 'Ubah Keterangan',
            html: "<textarea id='keterangan_new' class='form-control' placeholder='Tulis keterangan...'>" + get_current_keterangan + "</textarea>",
            showCancelButton: true,
            animation: true,
            confirmButtonText: 'Ubah',
            cancelButtonText: 'Batal',
            onOpen : function (swal){
                $('#keterangan_new').focus();
            }
        }).then(function () {
            // $(".btn").attr("disabled", true);
            var keterangan_val = $('#keterangan_new').val();
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    id   : id2,
                    keterangan : keterangan_val,
                    _token  : token
                },
                success: function( _response ){
                    console.log(_response.indicator);
                    if(_response.indicator == '1'){
                    swal(
                        'Sukses',
                        'Keterangan berhasil diubah!',
                        'success'
                        )
                        $('#keterangan_'+id2).text(keterangan_val);
                } else if (_response.indicator == '0') {
                    $( "#delete_schedule" ).trigger( "click" );
                    swal(
                        'Info',
                        'Gagal mengubah keterangan! Hubungi Admin',
                        'info'
                        )
                    $(".btn").attr("disabled", false); 
                }
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
});


var row_auditee = 1;
var row_auditor = 1;
function hapus_row_auditor(ths){
    var no = ths.substring(3);
    $("#row_auditor"+no).remove();
}

function hapus_row_auditee(ths){
    var no_aud = ths.substring(4);
    $("#row_auditee"+no_aud).remove();
}


function popupAuditee(ths) {
    var no_auditee = ths.substring(7);
    var myHeading = "<p>Popup Karyawan AUDITEE</p>";
        $("#karyawanModalLabel").html(myHeading);
        var url = "{{ route('datatables.popupKaryawanIA') }}";
        var lookupKaryawan = $('#lookupKaryawan').DataTable({
            processing: true,
            "oLanguage": {
                'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
            }, 
            // serverSide: true,
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
            "drawCallback": function( settings ) {
                $('.dataTables_filter input').focus();
            },
            "bDestroy": true,
            "initComplete": function(settings, json) {
            $('.dataTables_filter input').focus();
            $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
                var dataArr = [];
                var rows = $(this);
                var rowData = lookupKaryawan.rows(rows).data();
                $.each($(rowData),function(key,value){
                    document.getElementById(ths).value = value["nama"];
                    document.getElementById('npkaud'+no_auditee).value = value["npk"];
                    $('#karyawanModal').modal('hide');
                });
            });
            // $('#karyawanModal').on('hidden.bs.modal', function () {
            //     var line = document.getElementById(ths).value.trim();
            //     if(line === '') {
            //         document.getElementById(ths).value = "";
            //         $('#'+ths).focus();
            //     }
            // });
        },
        });
}

function popupKaryawanAuditor(ths) {
    $('.dataTables_filter input').focus();
    var remark = 'LEAD AUDITOR';
    
    var myHeading = "<p>Popup Karyawan AUDITOR</p>";
    $("#auditorModalLabel").html(myHeading);
    var url = "{{ route('datatables.popupKaryawanAuditor', 'param') }}";
    url = url.replace('param', remark)
    var lookupAuditor = $('#lookupAuditor').DataTable({
        processing: true,
        "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        }, 
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
        "drawCallback": function( settings ) {
            $('.dataTables_filter input').focus();
        },
        "bDestroy": true,
        "initComplete": function(settings, json) {
            $('.dataTables_filter input').focus();
            $('#lookupAuditor tbody').on( 'dblclick', 'tr', function () {
                var dataArr = [];
                var rows = $(this);
                var rowData = lookupAuditor.rows(rows).data();
                $.each($(rowData),function(key,value){
                    document.getElementById(ths).value = value["nama"];
                    document.getElementById('npklead').value = value["npk"];
                    $('#auditorModal').modal('hide');
                });
            });
            // $('#auditorModal').on('hidden.bs.modal', function () {
            //     var line = document.getElementById(ths).value.trim();
            //     if(line === '') {
            //         document.getElementById(ths).value = "";
            //         $('#'+ths).focus();
            //     }
            // });
        },
    });
}

function popupKaryawanAuditor2(ths) {
    $('.dataTables_filter input').focus();
    var remark = 'AUDITOR';
    var no_auditor = ths.substring(7);    
    var myHeading = "<p>Popup Karyawan AUDITOR</p>";
    $("#auditorModalLabel").html(myHeading);
    var url = "{{ route('datatables.popupKaryawanAuditor', 'param') }}";
    url = url.replace('param', remark)
    var lookupAuditor = $('#lookupAuditor').DataTable({
        processing: true,
        "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        }, 
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
        "drawCallback": function( settings ) {
            $('.dataTables_filter input').focus();
        },
        "bDestroy": true,
        "initComplete": function(settings, json) {
            $('.dataTables_filter input').focus();
            $('#lookupAuditor tbody').on( 'dblclick', 'tr', function () {
                var dataArr = [];
                var rows = $(this);
                var rowData = lookupAuditor.rows(rows).data();
                $.each($(rowData),function(key,value){
                    document.getElementById(ths).value = value["nama"];
                    document.getElementById('npkauditor'+no_auditor).value = value["npk"];
                    $('#auditorModal').modal('hide');
                });
            });
            // $('#auditorModal').on('hidden.bs.modal', function () {
            //     var line = document.getElementById(ths).value.trim();
            //     if(line === '') {
            //         document.getElementById(ths).value = "";
            //         $('#'+ths).focus();
            //     }
            // });
        },
    });
}


</script>

@endsection
