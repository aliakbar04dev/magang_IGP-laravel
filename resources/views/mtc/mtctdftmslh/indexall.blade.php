@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Masalah
        <small>Daftar Masalah</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MTC - Laporan</li>
        <li class="active">Daftar Masalah</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Laporan Daftar Masalah</h3>
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
              {!! Form::label('kd_plant', 'Plant') !!}
              <select size="1" id="kd_plant" name="kd_plant" class="form-control select2" onchange="changeKdPlant()">
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
            <div class="col-sm-4">
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
            <div class="col-sm-4">
              {!! Form::label('nm_mesin', 'Nama Mesin') !!}
              {!! Form::text('nm_mesin', null, ['class'=>'form-control','placeholder' => 'Nama Mesin', 'disabled'=>'', 'id' => 'nm_mesin']) !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
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
                <th style="width: 1%;">No</th>
                <th style="width: 5%;">Tgl</th>
                <th style="width: 20%;">Mesin</th>
                <th style="width: 20%;">Line</th>
                <th style="width: 25%;">Problem</th>
                <th>Counter Measure</th>
                <th>No. DM</th>
                <th>Site</th>
                <th>Plant</th>
                <th>No. PI</th>
                <th>No. LP</th>
                <th>Departemen</th>
                <th>Creaby</th>
                <th>Modiby</th>
                <th>Submit</th>
                <th>Approve PIC</th>
                <th>Approve Foreman</th>
                <th>Reject</th>
                <th>Tgl Plan Pengerjaan</th>
                <th>Status CMS</th>
                <th>Tgl Plan CMS</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button id='btnprint' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Print Laporan Daftar Masalah' onclick='printDM()'>
            <span class='glyphicon glyphicon-print'></span> Print Laporan Daftar Masalah
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

  function printDM()
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

        var kd_plant = document.getElementById("kd_plant").value;
        var kd_line = document.getElementById("kd_line").value;
        if(kd_line == "") {
          kd_line = "-";
        }
        var kd_mesin = document.getElementById("kd_mesin").value;
        if(kd_mesin == "") {
          kd_mesin = "-";
        }

        var urlRedirect = "{{ route('mtctdftmslhs.printdm', ['param','param2','param3','param4','param5']) }}";
        urlRedirect = urlRedirect.replace('param5', window.btoa(kd_mesin));
        urlRedirect = urlRedirect.replace('param4', window.btoa(kd_line));
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
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
      document.getElementById('display').focus();
    }
  }

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(kd_plant));
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
      var kd_plant = document.getElementById('kd_plant').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant));
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
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var url = '{{ route('datatables.popupMesins', ['param','param2']) }}';
    url = url.replace('param2', window.btoa(kd_line));
    url = url.replace('param', window.btoa(kd_plant));
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
            $('#display').focus();
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    if(kd_plant !== '' && kd_mesin !== '') {
      var url = '{{ route('datatables.validasiMesin', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(kd_mesin));
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant));
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
            document.getElementById("display").focus();
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
      "order": [[1, 'asc'],[2, 'asc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboardall.mtctdftmslhs') }}",
      columns: [
        {data: null, name: null},
        {data: 'tgl_dm', name: 'tgl_dm'},
        {data: 'mesin', name: 'mesin'},
        {data: 'line', name: 'line'}, 
        {data: 'ket_prob', name: 'ket_prob'},
        {data: 'ket_cm', name: 'ket_cm'},
        {data: 'no_dm', name: 'no_dm', className: "none"},
        {data: 'kd_site', name: 'kd_site', className: "none"},
        {data: 'kd_plant', name: 'kd_plant', className: "none"},
        {data: 'no_pi', name: 'no_pi', className: "none"},
        {data: 'no_lp', name: 'no_lp', className: "none", orderable: false, searchable: false},
        {data: 'kd_dep', name: 'kd_dep', className: "none", orderable: false, searchable: false},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'submit_npk', name: 'submit_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_pic_npk', name: 'apr_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_fm_npk', name: 'apr_fm_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_npk', name: 'rjt_npk', className: "none", orderable: false, searchable: false},
        {data: 'tgl_plan_mulai', name: 'tgl_plan_mulai', className: "none", orderable: false, searchable: false},
        {data: 'st_cms', name: 'st_cms', className: "none", orderable: false, searchable: false},
        {data: 'tgl_plan_cms', name: 'tgl_plan_cms', className: "none", orderable: false, searchable: false}
      ]
    });

    $(function() {
      $('\
        <div id="filter_status_apr" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Approve\
          <select size="1" name="filter_status_apr" aria-controls="filter_status_apr" \
            class="form-control select2" style="width: 150px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="F">Belum Submit</option>\
              <option value="T">Sudah Submit</option>\
              <option value="PIC">Approve PIC</option>\
              <option value="FM">Approve Foreman</option>\
              <option value="RJT">Reject</option>\
              <option value="LP">Sudah LP</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.tgl_awal = $('input[name="tgl_awal"]').val();
        data.tgl_akhir = $('input[name="tgl_akhir"]').val();
        data.kd_plant = $('select[name="kd_plant"]').val();
        data.kd_line = $('input[name="kd_line"]').val();
        data.kd_mesin = $('input[name="kd_mesin"]').val();
        data.status_apr = $('select[name="filter_status_apr"]').val();
      });

      $('select[name="filter_status_apr"]').change(function() {
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