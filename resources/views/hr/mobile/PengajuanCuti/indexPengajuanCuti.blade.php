@extends('layouts.app')
@section('content')

<style>
  .hide
{
    display : none;
}
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="content-header">
      <h1>
        TRANSAKSI
        <small>Pengajuan Cuti</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-lock"></i> Pengajuan Cuti</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="collapse" style="display:none;">
          <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add Pengajuan Cuti</h3>
                      <div class="box-tools pull-right">
                          <button type="button" id="ajucuti" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    {{-- {!! Form::open(['url' => route('pengajuancuti.submit'), 'method' => 'post', 'files' => 'true', 'role' =>
                    'form', 'id' => 'form_id'])
                    !!} --}}
                    <form action="javascript:void(0)" id="form_id">
        
                        {!! csrf_field() !!}
        
                    <!-- Add Forms Data Here-->
                    <div id="id_form_confirm">
                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          {!! Form::label('name', ' Nama Karyawan') !!}
                          {!! Form::text(null, $indent_name , ['class'=>'form-control', 'placeholder' => 'Nama Karyawan',
                          'maxlength' => 255, 'required', 'style' => 'text-transform:uppercase', 'onchange' =>
                          'autoUpperCase(this)', 'readonly' => true])
                          !!}
                          {!! Form::text('npk', $indent_npk, ['class'=>'form-control ', 'maxlength' => 255, 'style' =>
                          'display:none;'])
                          !!}
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          {!! Form::label('namaatasan', ' Nama Atasan') !!}
                          {{-- <select id="npk_atasan" name="npk_atasan" class="form-control select2" style="width:100%;">
                            <option value="{{ $indent_kar }}" selected>{{ $indent_kar }} - {{ $indent_atasan }}</option>
                              @foreach ($get_atasan as $atasan)
                                <option value="{{ $atasan->npk }}">{{ $atasan->npk }} - {{ $atasan->nama }}</option>
                              @endforeach
                            </option>
                          </select> --}}

                          <select id="npk_atasan" name="npk_atasan" class="form-control select2" style="width:100%;">
                              @if ($npk_atasan_div != '')
                              <option value="{{ $npk_atasan_div }}" selected>{{ $npk_atasan_div }} - {{ $inputatasan_div }}</option>
                              @endif
                              @if ($npk_atasan_dep != '')
                              <option value="{{ $npk_atasan_dep }}" selected>{{ $npk_atasan_dep }} - {{ $inputatasan_dep }}</option>
                              @endif
                              @if ($npk_atasan_sec != '')
                              <option value="{{ $npk_atasan_sec }}" selected>{{ $npk_atasan_sec }} - {{ $inputatasan_sec }}</option>
                              @endif
                              @foreach ($get_atasan as $atasan)
                              @if ($atasan->npk != $npk_atasan_div && $atasan->npk != $npk_atasan_dep && $atasan->npk != $npk_atasan_sec)
                                <option value="{{ $atasan->npk }}">{{ $atasan->npk }} - {{ $atasan->nama }}</option>
                              @endif
                              @endforeach
                              </option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('ct_akhir') ? ' has-error' : '' }}">
                          {!! Form::label('ct_akhir', ' Sisa Cuti Tahunan') !!}
                          {!! Form::text('ct_akhir', $saldocuti->ct_akhir, ['class'=>'form-control', 'required', 'readonly' => true])
                          !!}
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('cb_akhir') ? ' has-error' : '' }}">
                          {!! Form::label('cb_akhir', ' Sisa Cuti Besar') !!}
                          {!! Form::text('cb_akhir', $saldocuti->cb_akhir, ['class'=>'form-control', 'required', 'readonly' => true])
                          !!}
                        </div>
                      </div>

                      <!-- Date range -->
                     
                      <div class="col-lg-12">
                          <p class="help-block has-error">{!! Form::label('info', '* Isi ketiga input dibawah ini lalu klik add',
                              ['style'=>'color:black']) !!}</p>
                      </div>
                      <div class="col-lg-3">
                          
                          
                        <div class="form-group">
                          <label>Jenis Cuti:</label>
                          <div class="input-group">
                            <input class="form-control" id="kd_cutirange" value="CUTI TAHUNAN" data="CTH"
                               minlength="5" maxlength="50" required="required"
                              style="text-transform:uppercase;background-color:white;" readonly name="desc_cuti[]" type="text">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-info" onclick="showPopupKDCuti1(' + counter + ')"
                                data-toggle="modal" data-target="#KDCutiModal" style="height: 34px;">
                                <span class="glyphicon glyphicon-search"></span>
                              </button>
                            </span>
                          </div>
                          </<div>
                          <!-- /.input group -->
                        </div>
                      </div> 
        
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>Dari:</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                          <input type="text" id="tglAwal" name="tglAwal"  class="form-control daterange" style="background-color:white;"  value="<?php echo date('d/m/Y');?>" readonly/>
                          </div>
                          <!-- /.input group -->
                        </div>
                      </div>
        
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>Sampai:</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" id="tglAkhir" name="tglAkhir"  class="form-control daterange"  style="background-color:white;" value="<?php echo date('d/m/Y');?>" readonly/>
                          </div>
                          <!-- /.input group -->
                        </div>
                      </div>
        
                      <div class="col-lg-1">
                        <div class="form-group">
                          <label>Aksi:</label>
                          <div class="input-group">
                            <button type="button" class="btn btn-sm btn-success" id="addrowrange">
                              Add <i class="glyphicon glyphicon-plus"></i>
                            </button>
                          </div>
                          <!-- /.input group -->
                        </div>
                      </div>
        
        
                          <table id="myTable" class="table order-list table-striped table-responsive">
                              <thead>
                                <tr>
                                  <th>TANGGAL</th>
                                  <th>JENIS CUTI</th>
                                </tr>
                              </thead>
                            </table>
                    </div>
                    <!-- .box-footer -->
                  <div class="box-footer" style="display:none">
                      &nbsp;
                      {{-- {!! Form::submit('Save', ['class'=>'btn btn-success', 'id' => 'btn-save']) !!} --}}
                      <input type="submit" name="submit_form_id" id="submit_form_id" class="btn btn-success" value="Save">
                    </form>
                      &nbsp;&nbsp;
                      {{-- <a class="btn btn-danger" href="javascript:void(0)"
                        id="backButton">Clear</a> --}}
          
                      <input type="hidden" id="counterinput">
                      <a class="btn btn-primary" href="javascript:void(0)" id="clearButton" onclick="_clearButton()">Clear</a>
                    </div>
                  </div>
                  <!-- end Forms-->
        
                  
                  <!-- /.box-footer -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <div class="box-header with-border">
                <h3 class="box-title">Riwayat Pengajuan Cuti</h3>
              </div>
              <br>
              <a class="btn btn-primary" href="javaScript:void(0);" id="buttonAdd"><span class="fa fa-user-plus"></span> Add Pengajuan Cuti</a>
              <a class="btn btn-success" href="javaScript:void(0);" onclick="Cetak()"><span class="glyphicon glyphicon-print"></span> Cetak </a>
              <input type="text" id="inputchk" hidden>
              <br><br>
              <div class="alert alert-info" style="margin-bottom:0px;">
                <strong>Perhatian!</strong>
                <ul>
                    <li>Hubungi Atasan anda, infokan bahwa anda akan cuti.</li>
                    <li>Pastikan Cuti anda disetujui Atasan dengan melihat Status di Aplikasi ini. </li> 
                    <li>Setelah Disetujui, Cetak cuti ini agar Status tidak berubah lagi. </li>	
                </ul>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-dropdown">           
                    <option value="0">Belum Diproses</option>
                    <option value="2">Ditolak</option>
                    <option value="1">Disetujui</option>
                    <option value="">Semua</option>
                    </select></button>
                    <button id="refreshdata" class="btn btn-success">Refresh</button>
              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th style="width:100px;"><center>Info / Cetak</center></th> 
                    <th>Tgl Cuti</th> 
                    <th>Status</th>  
                    <th>Tgl Diproses</th>  
                    <th>No. Cuti</th>  
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div style="display: none">
          <form action="{{ route('pengajuancuti.cetak') }}" method="post">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="isi" id="isi">
            <input type="submit" name="submitCetak" id="submitCetak">
          </form>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('hr.mobile.PengajuanCuti.popup.KDCutiModal')
  @include('hr.mobile.PengajuanCuti.popupModal')
@endsection

@section('scripts')
<script type="text/javascript">
$( ".daterange" ).datepicker({ 
  daysOfWeekDisabled: [0,6],
  format: 'dd/mm/yyyy'
});
  $(document).ready(function(){
    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		cache: false,
		headers: { "cache-control": "no-cache" },
  });

  muncul()
  



  $(".select2").select2();
  $('#buttonAdd').on('click',function () {
    $(".collapse,.box-footer").show()
      $("#buttonAdd").hide()
    swal('Prosedur Input Cuti:', '<ul style="text-align:justify;"><li>1.	Hubungi Atasan anda(min. Section Head) terlebih dahulu utk minta ijin Cuti.</li><li>2.	Pastikan atasan anda menyetui Cuti tsb, baru input datanya di Aplikasi ini.</li><li>3.	Jika atasan tidak Approval (Persetujuan) di Aplikasi, maka data Cuti anda tidak ter-update di Absensi, oleh karenanya info ke atasan untuk approval setelah data cuti anda input.', 'info');
  });
    /***************************************
        Function : Valdiate date
        Require : Onblur =  checkdate ( this )
      **************************************/
      function isLeap(year) {
      if (year % 400 == 0) {
        return true;
      } else if ((year % 4 == 0) && (year % 100 != 0)) {
        return true
      } else return false;
    };

    function days_in(month, year) {
      if (month == 4 || month == 6 || month == 9 || month == 11) {
        return 30;
      } else if (!isLeap(year) && month == 2) {
        return 28;
      } else if (isLeap(year) && month == 2) {
        return 29;
      } else return 31;
    };

    checkDate = function (myItem) {
      var myArrayDate, myDay, myMonth, myYear, myString, myYearDigit;
      myString = myItem.value + "";
      if (myString == "" || myString == "dd/mm/yyyy") {
        myItem.value = "";
        return true;
      }
      myArrayDate = myString.split("/");

      myDay = Math.round(parseFloat(myArrayDate[0]));
      myMonth = Math.round(parseFloat(myArrayDate[1]));
      myYear = Math.round(parseFloat(myArrayDate[2]));
      myString = myYear + "";
      myYearDigit = myString.length;
      if (isNaN(myDay) || isNaN(myMonth) || isNaN(myYear) || (myYear < 1) || (myDay < 1) || (myMonth < 1) || (
          myMonth > 12) || (myYearDigit != 4) || (myDay > days_in(myMonth, myYear))) {
        swal('Warning!', 'Tanggal Yang Dimasukkan tidak benar format (dd/mm/yyyy).', 'warning');
        myItem.value = "";
        $("#btn-save").attr('disabled', true);
        return true;
      } else {
        $("#btn-save").attr('disabled', false);
        return false;
      }
    };

    

    /***************************************
      Function : Show Kode Cuti List 
      Require : Menampilkan Window popup Kode Cuti
    **************************************/

    var nomor = 0;
    showPopupKDCuti = function (counter) {
      var myHeading = "<p>Popup Jenis Cuti</p>";
      $("#KDCutiModalLabel").html(myHeading);
      var url = '{{ route('pengajuancuti.listkode_cuti') }}';
      var lookupKDCuti = $('#lookupKDCuti').DataTable({
        processing: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "lengthChange": false,
        "aLengthMenu": [
          [5, 10, 25, 50, 75, 100, -1],
          [5, 10, 25, 50, 75, 100, "All"]
        ],
        responsive: true,
        "order": [
          [1, 'asc']
        ],
        columns: [{
            data: 'kd_cuti',
            name: 'kd_cuti'
          },
          {
            data: 'desc_cuti',
            name: 'desc_cuti'
          },
          {
            data: 'hari',
            name: 'hari'
          }
        ],
        "bDestroy": true,
        "initComplete": function (settings, json) {
          $('#lookupKDCuti tbody').on('dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupKDCuti.rows(rows).data();
            $.each($(rowData), function (key, value) {

            });
          });
          $('#KDCutiModal').on('hidden.bs.modal', function () {
            $('#kd_cuti' + counter).focus();
          });

          //mobile device only uses click action triggered 
          $('#lookupKDCuti tbody').on('click', 'tr', function () {
          });

          $('#KDCutiModal').on('hidden.bs.modal', function () {
            //var kd_cuti = document.getElementById("kd_cuti" + counter).value.trim();
            $('#kd_cuti' + counter).focus();
          });

          var newRow = $("<tr id='tr_0'>");
      var cols = "";

      cols += '<td><input type="text" class="form-control" id="tgl' + counter +
        '" placeholder="dd/mm/yyyy" onblur="checkDate(this)"name="tgl[]"/></td>';
      cols += '<td><div class="input-group">' +
        '<input class="form-control" id="kd_cuti' + counter +
        '" placeholder="KD Cuti"  minlength="5" maxlength="50" required="required" style="text-transform:uppercase" readonly="1" name="kd_cuti[]" type="text">' +
        '<span class="input-group-btn">' +
        '<button type="button" class="btn btn-info data-toggle="modal" data-target="#KDCutiModal" style="height: 34px;">' +
        '<span class="glyphicon glyphicon-search"></span>' +
        '</button>' +
        '</span>' +
        '</div></td>';

      cols +=
        '<td><button  class="ibtnDel btn btn-sm btn-danger" value="Delete"><i class="glyphicon glyphicon-remove"></button></td>';

      newRow.append(cols);
      $("table.order-list").append(newRow);
      $("#tgl" + counter).inputmask();
      $("#counterinput").val(counter);
      $("#clearButton").show()
      $("#backButton").hide()
      counter++;
        },
      });
    }

    showPopupKDCuti1 = function (counter) {
      var myHeading = "<p>Popup Jenis Cuti</p>";
      $("#KDCutiModalLabel").html(myHeading);
      var url = '{{ route('pengajuancuti.listkode_cuti') }}';
      var lookupKDCuti = $('#lookupKDCuti').DataTable({
        processing: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        // serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "lengthChange": false,
        "aLengthMenu": [
          [5, 10, 25, 50, 75, 100, -1],
          [5, 10, 25, 50, 75, 100, "All"]
        ],
        responsive: true,
        "order": [
          [1, 'asc']
        ],
        columns: [{
            data: 'kd_cuti',
            name: 'kd_cuti'
          },
          {
            data: 'desc_cuti',
            name: 'desc_cuti'
          },
          {
            data: 'hari',
            name: 'hari'
          }
        ],
        "bDestroy": true,
        "initComplete": function (settings, json) {
          $('#lookupKDCuti tbody').on('dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupKDCuti.rows(rows).data();
            $.each($(rowData), function (key, value) {

            });
          });
          $('#KDCutiModal').on('hidden.bs.modal', function () {
            $('#kd_cuti' + counter).focus();
          });

          //mobile device only uses click action triggered 
          $('#lookupKDCuti tbody').on('click', 'tr', function () {
            var rows = $(this);
            var rowData = lookupKDCuti.rows(rows).data();
            $.each($(rowData), function (key, value) {
              $("#kd_cutirange").val(value["desc_cuti"]);
              $("#kd_cutirange").attr("data",value["kd_cuti"]);

              $('#KDCutiModal').modal('hide');
            });
          });

          $('#KDCutiModal').on('hidden.bs.modal', function () {
            //var kd_cuti = document.getElementById("kd_cuti" + counter).value.trim();
            $('#kd_cuti' + counter).focus();
          });

          var newRow = $("<tr id='tr_0'>");
    
        },
      });
    }

    $("#form_id").on('submit', function(e) {
    e.preventDefault();
    if($('#namaAtasan').val() !== '' && $('#npkAtasan').val() !== '' ){
      var data = $("#form_id").serialize();
    swal({
        html: `<ul>
            <li style='text-align:left;'>Pastikan Tanggal Pengajuan Cuti Tidak ada yang double/duplikat.</li>
            <li style='text-align:left;'>Sistem otomatis tidak akan memasukkan hari sabtu dan minggu ke database.</li>
            </ul>`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true
      }).then(function () {
        $.ajax({
        type: "post",
        url: '{{ route('pengajuancuti.submit') }}',
        data: data,
        dataType: "json",
        success: function(data) {
          if(data['pesan'] == 'sukses'){
            swal({
                title: "Cuti Berhasil Ditambahkan",
                text: data['msg'],
                html:
                  '<b>NO DOC ANDA: '+ data['nodoc']+ '</b><br><br>' + data['msg'],
                type: "success"
            }).then(function() {
              location.reload();
            });
          }else{
            swal('Perhatian!', data['msg'], 'warning');
          }
          
        },
        error: function(error) {
          swal({
                title: "Cuti Gagal Ditambahkan",
                text: data['msg'],
                html: `<ul>
                <li style='text-align:left;'>Belum Ada data cuti, mohon tambahkan data dengan klik add.</li>
                <li style='text-align:left;'>Pastikan sudah mendapat persetujuan atasan anda baru anda mengambil cuti.</li>
                </ul>`,
                type: "warning"
            })
            //   swal('Warning!', ' ', 'error');
            }
        });
      }, function (dismiss) {
        if (dismiss === 'cancel') {
          swal('Cancelled', 'Pengajuan Cuti Dibatalkan', 'warning');
        }
      })
    }else{
      swal({
                title: "Nama Atasan Tidak Diketahui",
                html: `<ul>
                <li style='text-align:left;'>Mohon meminta update NPK atasan anda ke pihak HRD.</li>
                </ul>`,
                type: "warning"
            })
    }
    
});


    /*************************************
      Tambah Kurang rows
    *************************************/
    var counter = 1;
    $("#addrow").on("click", function () {
      var newRow = $("<tr id='tr_0'>");
      var cols = "";

      cols += '<td><input type="text" class="form-control" id="tgl' + counter +
        '" placeholder="dd/mm/yyyy" onblur="checkDate(this)"name="tgl[]"/></td>';
      cols += '<td><div class="input-group">' +
        '<input class="form-control" id="kd_cuti' + counter +
        '" placeholder="KD Cuti"  minlength="5" maxlength="50" required="required" style="text-transform:uppercase" readonly="1" name="kd_cuti[]" type="text">' +
        '<span class="input-group-btn">' +
        '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#KDCutiModal" style="height: 34px;">' +
        '<span class="glyphicon glyphicon-search"></span>' +
        '</button>' +
        '</span>' +
        '</div></td>';

      cols +=
        '<td><button class="ibtnDel btn btn-sm btn-danger" value="Delete"><i class="glyphicon glyphicon-remove"></button></td>';

      newRow.append(cols);
      $("table.order-list").append(newRow);
      $("#tgl" + counter).inputmask();
      $("#counterinput").val(counter);
      $("#clearButton").show()
      $("#backButton").hide()
      counter++;
    });

    var counter = 1;
    $("#addrowrange").on("click", function () {

      var DescCuti = $("#kd_cutirange").val();
      var kdCutiRange = $("#kd_cutirange").attr("data");
      var tglAwal =  $("#tglAwal").val().split(/\//).reverse().join('/');
      var tglAkhir =  $("#tglAkhir").val().split(/\//).reverse().join('/');


      var start = new Date(tglAwal);
      var end = new Date(tglAkhir);

      var daysOfYear = [];
      for (var d = start; d <= end; d.setDate(d.getDate() + 1)) {
          var newRow = $("<tr id='tr_0'>");
          var cols = "";

          cols += '<td><input type="text" class="form-control" id="tgl' + counter +
            '" value="'+ moment(d).format("DD/MM/YYYY") +'" readonly onblur="checkDate(this)"name="tgl[]"/></td>';
          cols += '<td>' +
            '<input class="form-control" id="desc_cuti' + counter +
            '" value="'+ DescCuti +'"  minlength="5" maxlength="50" required="required" style="text-transform:uppercase" readonly="1" name="desc_cuti[]" type="text">' +
            '</td><input type="hidden" id="kd_cuti" name="kd_cuti[]" value="'+ kdCutiRange +'">';

          cols +=
            '<td><button style="padding:7px 8px;" class="ibtnDel btn btn-sm btn-danger" style="text-transform:uppercase" readonly="1" value="Delete"><i class="glyphicon glyphicon-remove"></button></td>';

          newRow.append(cols);
          $("table.order-list").append(newRow);
          $("#tgl" + counter).inputmask();
          $("#counterinput").val(counter);
          $("#clearButton").show()
          $("#backButton").hide()
          counter++;
      }

      
      
    });

    $("table.order-list").on("click", ".ibtnDel", function (event) {
      $(this).closest("tr").remove();
      counter -= 1;
      sco = $("#counterinput").val() - 1;
      if (sco == 0) {
        $("#clearButton").hide();
        $("#backButton").show()
      }
    });

    /**
     *  Clear Button 
     **/
    _clearButton = function () {
      $("table.order-list > tbody").html("");
      $("#counterinput").val(0)
      $("#clearButton").hide();
      $("#backButton").show()
    }

    // BATAS FORM
    

    function muncul(){
      $('#table-dropdown').ready(function(){
      tableDetail.column(2).search('0').draw();   
        });    
        $('#table-dropdown').on('change', function(){
          tableDetail.column(2).search(this.value).draw();   
        }); 

    
    var tableDetail = $('#tblMaster').DataTable({
      "iDisplayLength": 10,
	      responsive: {
            details: {
                type: 'column',
                target: 1
            }
        },
		
        "order": [
          [1, 'desc']
        ],
		columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:  []
        }],
	      processing: true,
		  serverSide:true, 
	      destroy: true, 
	      searching: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      ajax: "{{ route('pengajuancuti.listpengajuancuti') }}",
      columns: [
        {data: 'cetak', name: 'cetak', sortable:false,searchable:false},
        {data: 'tglcuti', name: 'tglcuti', sortable:false,searchable:false},
        {data: 'status', name: 'status'},
        {data: 'tglapprov', name: 'tglapprov'},
        {data: 'no_cuti', name: 'no_cuti'},
      ],
    });

    $("#refreshdata").on("click", function (event) {
          tableDetail.ajax.reload();
    });


    

    
    }

    
    

	
  	/*Pengajuan cuti atasan validate*/
	
  	//Tampung data checklist
	
  	//Tombol Cetak diklik
  	Cetak =  function()
  	{

      var a = [];
      $("[name='chk[]']:checked").each(function() {
          a.push(this.value);
      });
      if(a.length == 0 ){
        swal(
          'Warning',
          'Silahkan Pilih Data yang ingin dicetak terlebih dahulu',
          'warning'
        )
      }else{
        
        $("#isi").val(a);


        $('#submitCetak').click();
      }
  		
  	}
  });

  

  function showPopupModal(no_cuti){
			$('#backButton').on('click', function () {
				$('#popupModal').modal('hide');
			})
			// var no_cuti = $('#btnInfoNocuti'+npk).val();
			
			var myHeading = "<p>Popup Detail Pengajuan Cuti</p>";
			$("#popupModalLabel1").html(myHeading);
			var url = '{{route("pengajuancuti.listdetail",['+no_cuti+'])}}';
			var tblDetailMaster = $('#tblDetailMaster').DataTable({
				processing: true,
				"oLanguage": {
				'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
				},
				"columnDefs": [{
					"searchable": false,
					"orderable": false,
					"targets": 0,
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				}],
				"pagingType": "numbers",
        scrollY:'200px',
				paging:false,
				ajax: {
				url: url,
				type: 'GET',
				data: {
				no_cuti:no_cuti
				}},
				"lengthChange": false,
				"aLengthMenu": [
				[5, 10, 25, 50, 75, 100, -1],
				[5, 10, 25, 50, 75, 100, "All"]
				],
				responsive: true,
				searching:true,
				columns: [{data: null, name: null, orderable: false, searchable: false},  
		    	{data: 'tglcuti', name: 'tglcuti'}, 
		    	{data: 'kd_cuti', name: 'kd_cuti'},
		    	{data: 'desc_cuti', name: 'desc_cuti'} 
				],
				"bDestroy": true,
				"initComplete": function (settings, json) {
				},
			});

			$.ajax({
				type: "get",
				url: '{{ route("pengajuancuti.viewdetails") }}',
				data: {
					no_cuti:no_cuti
				},
				dataType: "json",
				success: function(data) {
					$('#npkDetail').html(data['npk'])
					$('#namaDetail').html(data['nama'])
					$('#tglDetail').html(data['tglpengajuan'])
					$('#bagDetail').html(data['desc_dep']+' '+ data['desc_sie'])
					$('#nodocDetail').html(data['nodoccuti'])
          $('#sisaCutiTahunan').html(data['ct_akhir']+' (Saat ini)')
					$('#sisaCutiBesar').html(data['cb_akhir']+' (Saat ini)')
					$('#namaAtasanDetail').html(data['namaatasan'])
          
				
				},
				error: function(error) {
					//   swal('Warning!', ' ', 'error');
					}
				});
		}

    function Delete(no_cuti)
		{ 
			swal({ 
				text: "Apakah anda yakin menghapus pengajuan cuti ini?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus !',
				cancelButtonText: 'Tidak, Batalkan!',
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				buttonsStyling: true
			}).then(function() {
    			var data = $("#formDelete"+no_cuti).serialize();

				$.ajax({
					type: "post",
					url: '{{ route('pengajuancuti.destroy') }}',
					data: data,
					dataType: "json",
					success: function(data) {
					if(data['pesan'] == 'Sukses'){
						swal({
							title: "Cuti Berhasil Dihapus",
							text: data['msg'],
							type: "success"
						}).then(function() {
							$('#refreshdata').click();
						});
					}else{
						swal('Warning!', 'Gagal!', 'info');
					}
					
					},
					error: function(error) {
						swal('Warning!', 'Belum Ada data cuti, mohon tambahkan data dengan klik add. pastikan sudah mendapat persetujuan atasan anda baru anda mengambil cuti.', 'info');
						}
					});
				
			}, function(dismiss) { 
				if (dismiss === 'cancel') {
					swal('Cancelled', 'Dibatalkan', 'warning');
				}
			}) 
		}
    
  
  
</script>
@endsection