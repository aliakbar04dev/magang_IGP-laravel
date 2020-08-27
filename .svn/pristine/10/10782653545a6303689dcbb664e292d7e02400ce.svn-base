@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Pekerjaan
        <small>Laporan Pekerjaan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MTC - Laporan</li>
        <li class="active">Laporan Pekerjaan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Laporan Pekerjaan</h3>
        </div>
        <!-- /.box-header -->
        
        <div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('tgl_awal', 'Tanggal Awal') !!}
              {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('tgl_akhir', 'Tanggal Akhir') !!}
              {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('shift', 'Shift') !!}
              {!! Form::select('shift', ['-' => 'ALL', '1' => '1', '2' => '2', '3' => '3'], null, ['class'=>'form-control select2', 'id' => 'shift']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('lok_pt', 'Plant') !!}
              <select size="1" id="lok_pt" name="lok_pt" class="form-control select2" onchange="changeKdPlant()">
                <option value="-" selected="selected">ALL</option>
                @foreach($plant->get() as $kode)
                  <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('kd_line', 'Line (F9)') !!}
              <div class="input-group">
                {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                <span class="input-group-btn">
                  <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-6">
              {!! Form::label('nm_line', 'Nama Line') !!}
              {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('kd_mesin', 'Mesin (F9)') !!}
              <div class="input-group">
                {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'id' => 'kd_mesin']) !!}
                <span class="input-group-btn">
                  <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-6">
              {!! Form::label('nm_mesin', 'Nama Mesin') !!}
              {!! Form::text('nm_mesin', null, ['class'=>'form-control','placeholder' => 'Nama Mesin', 'disabled'=>'', 'id' => 'nm_mesin']) !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('st_pms', 'Info Kerja') !!}
              {!! Form::select('st_pms', ['-' => 'ALL', 'ANDON' => 'ANDON', 'PMS' => 'PMS', 'CMS' => 'CMS', 'DM' => 'DM', 'PROJECT' => 'PROJECT', 'LANGSUNG' => 'LANGSUNG'], null, ['class'=>'form-control select2', 'id' => 'st_pms']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblusername2', ' ') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th rowspan="2" style="width: 1%;">No</th>
                <th rowspan="2" style="width: 5%;">Tgl</th>
                <th rowspan="2" style="width: 5%;">Shift</th>
                <th rowspan="2" style="width: 5%;">Mesin</th>
                <th rowspan="2" style="width: 20%;">Problem</th>
                <th rowspan="2">Counter Measure</th>
                <th colspan="2" style='text-align: center'>Jam</th>
                <th rowspan="2" style="width: 5%;">Total</th>
                <th rowspan="2" style="width: 5%;">Status</th>
                <th rowspan="2">No. LP</th>
                <th rowspan="2">Plant</th>
                <th rowspan="2">Line</th>
                <th rowspan="2">Nama Mesin</th>
                <th rowspan="2">Info Kerja</th>
                <th rowspan="2">Main Item</th>
                <th rowspan="2">IC</th>
                <th rowspan="2">No. LHP</th>
                <th rowspan="2">LS Mulai</th>
                <th rowspan="2">No. PMS</th>
                <th rowspan="2">No. DM</th>
                <th rowspan="2">Creaby</th>
                <th rowspan="2">Modiby</th>
                <th rowspan="2">Approve PIC</th>
                <th rowspan="2">Approve Section</th>
                <th rowspan="2">Reject</th>
              </tr>
              <tr>
                <th style="width: 5%;">Mulai</th>
                <th style="width: 5%;">Selesai</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button id='btnprint' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Print Laporan Pekerjaan Harian' onclick='printLP()'>
            <span class='glyphicon glyphicon-print'></span> Print Laporan Pekerjaan Harian
          </button>
          &nbsp;&nbsp;
          <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
        </div>
      </div>
      <!-- /.box -->

      <!-- Modal Line -->
      @include('mtc.lp.popup.lineModal')
      <!-- Modal Mesin -->
      @include('mtc.lp.popup.mesinModal')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  document.getElementById("tgl_awal").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function printLP()
  {
    var tgl_awal = document.getElementById("tgl_awal").value;
    var tgl_akhir = document.getElementById("tgl_akhir").value;
    if(tgl_awal == "" || tgl_akhir == "") {
      swal("Tgl Awal & Akhir tidak boleh kosong!", "Perhatikan inputan anda!", "error");
    } else {
      var msg = 'Anda yakin print data ini?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, print it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {

        var shift = document.getElementById("shift").value;
        var lok_pt = document.getElementById("lok_pt").value;
        var st_pms = document.getElementById("st_pms").value;
        var kd_line = document.getElementById("kd_line").value;
        if(kd_line == "") {
          kd_line = "-";
        }
        var kd_mesin = document.getElementById("kd_mesin").value;
        if(kd_mesin == "") {
          kd_mesin = "-";
        }

        var urlRedirect = "{{ route('tmtcwo1s.printlp', ['param','param2','param3','param4','param5','param6','param7']) }}";
        urlRedirect = urlRedirect.replace('param7', window.btoa(st_pms));
        urlRedirect = urlRedirect.replace('param6', window.btoa(kd_mesin));
        urlRedirect = urlRedirect.replace('param5', window.btoa(kd_line));
        urlRedirect = urlRedirect.replace('param4', window.btoa(lok_pt));
        urlRedirect = urlRedirect.replace('param3', window.btoa(shift));
        urlRedirect = urlRedirect.replace('param2', window.btoa(tgl_akhir));
        urlRedirect = urlRedirect.replace('param', window.btoa(tgl_awal));
        // window.location.href = urlRedirect;
        window.open(urlRedirect, '_blank');
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
    }
  }

  function changeKdPlant() {
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_mesin').focus();
    }
  }

  function keyPressedKdMesin(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupmesin').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('st_pms').focus();
    }
  }

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var lok_pt = document.getElementById('lok_pt').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(lok_pt));
    var lookupLine = $('#lookupLine').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
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
        { data: 'xkd_line', name: 'xkd_line'},
        { data: 'xnm_line', name: 'xnm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLine.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_line").value = value["xkd_line"];
            document.getElementById("nm_line").value = value["xnm_line"];
            $('#lineModal').modal('hide');
            validateKdLine();
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kd_line = document.getElementById("kd_line").value.trim();
          if(kd_line === '') {
            document.getElementById("nm_line").value = "";
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            $('#kd_line').focus();
          } else {
            $('#kd_mesin').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var lok_pt = document.getElementById('lok_pt').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(lok_pt));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];
          validateKdMesin();
        } else {
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          // document.getElementById("kd_mesin").value = "";
          // document.getElementById("nm_mesin").value = "";
          document.getElementById("kd_line").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      // document.getElementById("kd_mesin").value = "";
      // document.getElementById("nm_mesin").value = "";
    }
  }

  function popupKdMesin() {
    var myHeading = "<p>Popup Mesin</p>";
    $("#mesinModalLabel").html(myHeading);
    var lok_pt = document.getElementById('lok_pt').value.trim();
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var url = '{{ route('datatables.popupMesins', ['param','param2']) }}';
    url = url.replace('param2', window.btoa(kd_line));
    url = url.replace('param', window.btoa(lok_pt));
    var lookupMesin = $('#lookupMesin').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
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
        { data: 'kd_mesin', name: 'kd_mesin'},
        { data: 'nm_mesin', name: 'nm_mesin'},
        { data: 'kd_line', name: 'kd_line'},
        { data: 'nm_line', name: 'nm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupMesin tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupMesin.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_mesin").value = value["kd_mesin"];
            document.getElementById("nm_mesin").value = value["nm_mesin"];
            document.getElementById("kd_line").value = value["kd_line"];
            document.getElementById("nm_line").value = value["nm_line"];
            $('#mesinModal').modal('hide');
            validateKdMesin();
          });
        });
        $('#mesinModal').on('hidden.bs.modal', function () {
          var kd_mesin = document.getElementById("kd_mesin").value.trim();
          if(kd_mesin === '') {
            document.getElementById("nm_mesin").value = "";
            $('#kd_mesin').focus();
          } else {
            $('#st_pms').focus();
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var lok_pt = document.getElementById('lok_pt').value.trim();
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    if(lok_pt !== '' && kd_mesin !== '') {
      var url = '{{ route('datatables.validasiMesin', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(kd_mesin));
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(lok_pt));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          if(result["jml_row"] != null) {
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            document.getElementById("kd_line").value = "";
            document.getElementById("nm_line").value = "";
            document.getElementById("kd_mesin").focus();
            swal("Terdapat " + result["jml_row"] + " Line. Pilih dari Popup.", "tekan F9 untuk tampilkan data.", "warning");
          } else {
            document.getElementById("kd_mesin").value = result["kd_mesin"];
            document.getElementById("nm_mesin").value = result["nm_mesin"];
            document.getElementById("kd_line").value = result["kd_line"];
            document.getElementById("nm_line").value = result["nm_line"];
            document.getElementById("st_pms").focus();
          }
        } else {
          document.getElementById("kd_mesin").value = "";
          document.getElementById("nm_mesin").value = "";
          document.getElementById("kd_mesin").focus();
          swal("Mesin tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_mesin").value = "";
      document.getElementById("nm_mesin").value = "";
    }
  }

  $(document).ready(function(){

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    $("#btnpopupmesin").click(function(){
      popupKdMesin();
    });

    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
      render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
      }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[1, 'asc'],[6, 'asc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboardall.tmtcwo1s') }}",
      columns: [
        {data: null, name: null},
        {data: 'tgl_wo', name: 'tgl_wo'},
        {data: 'shift', name: 'shift', className: "dt-center"},
        {data: 'kd_mesin', name: 'kd_mesin'},
        {data: 'uraian_prob', name: 'uraian_prob'},
        {data: 'langkah_kerja', name: 'langkah_kerja'},
        {data: 'est_jamstart', name: 'est_jamstart', className: "dt-center"},
        {data: 'est_jamend', name: 'est_jamend', className: "dt-center"},
        {data: 'est_durasi', name: 'est_durasi', className: "dt-right"},
        {data: 'st_close', name: 'st_close', orderable: false, searchable: false},
        {data: 'no_wo', name: 'no_wo', className: "none"},
        {data: 'lok_pt', name: 'lok_pt', className: "none"},
        {data: 'line', name: 'line', className: "none"}, 
        {data: 'mesin', name: 'mesin', className: "none"},
        {data: 'info_kerja', name: 'info_kerja', className: "none"},
        {data: 'st_main_item', name: 'st_main_item', className: "none", orderable: false, searchable: false},
        {data: 'no_ic', name: 'no_ic', className: "none", orderable: false, searchable: false},
        {data: 'no_lhp', name: 'no_lhp', className: "none"},
        {data: 'ls_mulai', name: 'ls_mulai', className: "none", orderable: false, searchable: false},
        {data: 'no_pms', name: 'no_pms', className: "none"},
        {data: 'no_dm', name: 'no_dm', className: "none"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'apr_pic_npk', name: 'apr_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_sh_npk', name: 'apr_sh_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_npk', name: 'rjt_npk', className: "none", orderable: false, searchable: false}
      ]
    });

    $(function() {
      $('\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Status LP\
          <select size="1" name="filter_status" aria-controls="filter_status" \
            class="form-control select2" style="width: 125px;">\
              <option value="ALL" selected="selected">All</option>\
              <option value="F">Belum Selesai</option>\
              <option value="T">Sudah Selesai</option>\
              <option value="PIC">Approve PIC</option>\
              <option value="SH">Approve Section</option>\
              <option value="RJT">Reject</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.tgl_awal = $('input[name="tgl_awal"]').val();
        data.tgl_akhir = $('input[name="tgl_akhir"]').val();
        data.shift = $('select[name="shift"]').val();
        data.lok_pt = $('select[name="lok_pt"]').val();
        data.kd_line = $('input[name="kd_line"]').val();
        data.kd_mesin = $('input[name="kd_mesin"]').val();
        data.st_pms = $('select[name="st_pms"]').val();
        data.status = $('select[name="filter_status"]').val();
      });

      $('select[name="filter_status"]').change(function() {
        tableMaster.ajax.reload();
      });
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    //$('#display').click();
  });
</script>
@endsection