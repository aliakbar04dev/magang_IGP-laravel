@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daily Activity Zone
        <small>Daily Activity Zone</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Daily Activity Zone</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::open(['url' => route('mtctpmss.store'),
          'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}
        {!! Form::hidden('status_action', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'status_action']) !!}
        {!! Form::hidden('keterangan', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'keterangan']) !!}
        {!! Form::hidden('datapms', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'datapms']) !!}
        {!! Form::hidden('kd_mesin_pms', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kd_mesin_pms']) !!}
        {!! Form::hidden('kd_plant_pms', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kd_plant_pms']) !!}
        <div class="box box-primary">        
      		<div class="box-body form-horizontal">
            <div class="form-group">
              <div class="col-sm-2">
                {!! Form::label('lblplant', 'Plant') !!}
                <select name="filter_plant" aria-controls="filter_status" class="form-control select2">
                  <option value="ALL" selected="selected">ALL</option>
                  @foreach($plant->get() as $kode)
                    <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-2">
                {!! Form::label('lblzona', 'Zona') !!}
                <select name="filter_zona" aria-controls="filter_status" class="form-control select2">
                  <option value="ALL" selected="selected">ALL</option>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
              </div>
              <div class="col-sm-2">
                {!! Form::label('lbltgl', 'Tanggal') !!}
                {!! Form::date('filter_tgl', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tanggal', 'id' => 'filter_tgl']) !!}
              </div>
              <div class="col-sm-2">
                {!! Form::label('lbldisplay', ' ') !!}
                <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>
            </div>
      		</div>
      		<!-- /.box-body -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">
                      <p><label id="info-detail">PMS Outstanding</label></p>
                    </h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th style="width: 1%;">No</th>
                          <th style="text-align: center;width: 2%;"><input type="checkbox" name="chk-all" id="chk-all"></th>
                          <th style="width: 5%;">Mesin</th>
                          <th>Item Pengerjaan</th>
                          <th style="width: 10%;">Tanggal</th>
                          <th style="width: 15%;">No. LP</th>
                          <th style="width: 25%;">Pending</th>
                          <th>No. PMS</th>
                          <th>No. MS</th>
                          <th>Plant</th>
                          <th>Periode</th>
                          <th>PIC Tarik</th>
                          <th>PIC Pending</th>
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
          </div>
          <!-- /.box-body -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">
                      <p><label id="info-detail">PMS Current Day</label></p>
                    </h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <table id="tblCurrent" class="table table-bordered table-striped" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th style="width: 1%;">No</th>
                          <th style="text-align: center;width: 2%;"><input type="checkbox" name="chk-all2" id="chk-all2"></th>
                          <th style="width: 5%;">Mesin</th>
                          <th>Item Pengerjaan</th>
                          <th style="width: 10%;">Tanggal</th>
                          <th style="width: 15%;">No. LP</th>
                          <th style="width: 25%;">Pending</th>
                          <th>No. PMS</th>
                          <th>No. MS</th>
                          <th>Plant</th>
                          <th>Periode</th>
                          <th>PIC Tarik</th>
                          <th>PIC Pending</th>
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
          </div>
          <!-- /.box-body -->
        </div>
        <div>
          @permission(['mtc-lp-create'])
            {!! Form::submit('Buat Laporan Pekerjaan / Pending', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
            &nbsp;&nbsp;
          @endpermission
          <a class="btn btn-primary" href="{{ route('tmtcwo1s.index') }}">
            <span class="fa fa-book"></span> Daftar Laporan Pekerjaan
          </a>
        </div>
        <!-- /.box -->
      {!! Form::close() !!}
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

$('#form_id').submit(function (e, params) {
  var localParams = params || {};
  if (!localParams.send) {
    e.preventDefault();
    var validasi = "F";
    var ids = "-";
    var jmldataM = 0;
    var jmldataC = 0;
    var kd_mesin = "";
    var kd_plant = "";
    var validasiKdMesin = "T";

    var tableM = $('#tblMaster').DataTable();
    tableM.search('').columns().search('').draw();
    for($i = 0; $i < tableM.rows().count(); $i++) {
      var no = $i + 1;
      var data = tableM.cell($i, 1).data();
      var posisi = data.indexOf("chk");
      var target = data.substr(0, posisi);
      target = target.replace('<input type="checkbox" name="', '');
      target = target.replace("<input type='checkbox' name='", '');
      target = target.replace("<input type='checkbox' name=", '');
      target = target.replace('<input name="', '');
      target = target.replace("<input name='", '');
      target = target.replace("<input name=", '');
      target = target +'chk';
      if(document.getElementById(target) != null) {
        var checked = document.getElementById(target).checked;
        if(checked == true) {
          var kd_mesin_temp = tableM.cell($i, 2).data();
          if(kd_mesin === "") {
            kd_mesin = kd_mesin_temp;
            var kd_plant_temp = tableM.cell($i, 9).data();
            kd_plant = kd_plant_temp;
          }
          if(kd_mesin === kd_mesin_temp) {
            var no_pms = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_pms;
            } else {
              ids = ids + "#quinza#" + no_pms;
            }
            jmldataM = jmldataM + 1;
          } else {
            validasiKdMesin = "F";
            $i = tableM.rows().count();
          }
        }
      }
    }

    var tableC = $('#tblCurrent').DataTable();
    tableC.search('').columns().search('').draw();
    for($i = 0; $i < tableC.rows().count(); $i++) {
      var no = $i + 1;
      var data = tableC.cell($i, 1).data();
      var posisi = data.indexOf("chk");
      var target = data.substr(0, posisi);
      target = target.replace('<input type="checkbox" name="', '');
      target = target.replace("<input type='checkbox' name='", '');
      target = target.replace("<input type='checkbox' name=", '');
      target = target.replace('<input name="', '');
      target = target.replace("<input name='", '');
      target = target.replace("<input name=", '');
      target = target +'chk';
      if(document.getElementById(target) != null) {
        var checked = document.getElementById(target).checked;
        if(checked == true) {
          var kd_mesin_temp = tableC.cell($i, 2).data();
          if(kd_mesin === "") {
            kd_mesin = kd_mesin_temp;
            var kd_plant_temp = tableC.cell($i, 9).data();
            kd_plant = kd_plant_temp;
          }
          if(kd_mesin === kd_mesin_temp) {
            var no_pms = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_pms;
            } else {
              ids = ids + "#quinza#" + no_pms;
            }
            jmldataC = jmldataC + 1;
          } else {
            validasiKdMesin = "F";
            $i = tableC.rows().count();
          }
        }
      }
    }
    
    if(validasi === "T" && validasiKdMesin === "T") {
      //additional input validations can be done hear
      swal({
        title: 'Buat LP / Pending?',
        text: 'Jumlah Data Outstanding: ' + jmldataM + '. Jumlah Data Current: ' + jmldataC,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="glyphicon glyphicon-book"></i> Buat LP!',
        cancelButtonText: '<i class="glyphicon glyphicon-pause"></i> Pending!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: false,
      }).then(function () {
        document.getElementById("datapms").value = ids;
        document.getElementById("status_action").value = "LP";
        document.getElementById("kd_mesin_pms").value = kd_mesin;
        document.getElementById("kd_plant_pms").value = kd_plant;
        document.getElementById("keterangan").value = "-";
        $(e.currentTarget).trigger(e.type, { 'send': true });
      }, function (dismiss) {
        if (dismiss === 'cancel') {
          swal({
            title: 'Input Keterangan Pending',
            html:
              '<textarea id="swal-input1" class="form-control" maxlength="100" rows="3" cols="20" placeholder="Keterangan Pending (Max. 100 Karakter)" style="resize:vertical">',
            preConfirm: function () {
              return new Promise(function (resolve, reject) {
                if ($('#swal-input1').val()) {
                  if($('#swal-input1').val().length < 10) {
                    reject('Keterangan Pending Min 10 Karakter!')
                  } else if($('#swal-input1').val().length > 100) {
                    reject('Keterangan Pending Max 100 Karakter!')
                  } else {
                    resolve([
                      $('#swal-input1').val()
                    ])
                  }
                } else {
                  reject('Keterangan Pending tidak boleh kosong!')
                }
              })
            }
          }).then(function (result) {
            document.getElementById("datapms").value = ids;
            document.getElementById("status_action").value = "PENDING";
            document.getElementById("kd_mesin_pms").value = kd_mesin;
            document.getElementById("kd_plant_pms").value = kd_plant;
            document.getElementById("keterangan").value = result[0];
            $(e.currentTarget).trigger(e.type, { 'send': true });
          }).catch(swal.noop)
        }
      })
    } else {
      if(validasiKdMesin !== "T") {
        swal("Kode Mesin tidak boleh berbeda!", "", "warning");
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");
      }
    }
  }
});

$(document).ready(function(){

  var urlMaster = '{{ route('dashboard.mtctpmss', 'param') }}';
  urlMaster = urlMaster.replace('param', window.btoa("OUTSTANDING"));
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
    "iDisplayLength": 5,
    responsive: true,
    "order": [[10, 'asc'],[2, 'asc'],[8, 'asc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: urlMaster, 
    columns: [
      {data: null, name: null},
      {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false},
      {data: 'kd_mesin', name: 'kd_mesin'},
      {data: 'nm_ic', name: 'nm_ic'},
      {data: 'nm_tgl', name: 'nm_tgl'},
      {data: 'no_lp', name: 'no_lp'},
      {data: 'pending_ket', name: 'pending_ket'},
      {data: 'no_pms', name: 'no_pms', className: "none"},
      {data: 'no_ms', name: 'no_ms', className: "none"},
      {data: 'kd_plant', name: 'kd_plant', className: "none"},
      {data: 'periode', name: 'periode', className: "none"},
      {data: 'pic_tarik', name: 'pic_tarik', className: "none"},
      {data: 'pending_pic', name: 'pending_pic', className: "none"}
    ], 
  });

  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
    data.plant = $('select[name="filter_plant"]').val();
    data.zona = $('select[name="filter_zona"]').val();
    data.tgl = $('input[name="filter_tgl"]').val();
  });

  var urlCurrent = '{{ route('dashboard.mtctpmss', 'param') }}';
  urlCurrent = urlCurrent.replace('param', window.btoa("CURRENT"));
  var tableCurrent = $('#tblCurrent').DataTable({
    "columnDefs": [{
      "searchable": false,
      "orderable": false,
      "targets": 0,
    render: function (data, type, row, meta) {
        return meta.row + meta.settings._iDisplayStart + 1;
    }
    }],
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 5,
    responsive: true,
    "order": [[10, 'asc'],[2, 'asc'],[8, 'asc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: urlCurrent, 
    columns: [
      {data: null, name: null},
      {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false},
      {data: 'kd_mesin', name: 'kd_mesin'},
      {data: 'nm_ic', name: 'nm_ic'},
      {data: 'nm_tgl', name: 'nm_tgl'},
      {data: 'no_lp', name: 'no_lp'},
      {data: 'pending_ket', name: 'pending_ket'},
      {data: 'no_pms', name: 'no_pms', className: "none"},
      {data: 'no_ms', name: 'no_ms', className: "none"},
      {data: 'kd_plant', name: 'kd_plant', className: "none"},
      {data: 'periode', name: 'periode', className: "none"},
      {data: 'pic_tarik', name: 'pic_tarik', className: "none"},
      {data: 'pending_pic', name: 'pending_pic', className: "none"}
    ], 
  });

  $("#tblCurrent").on('preXhr.dt', function(e, settings, data) {
    data.plant = $('select[name="filter_plant"]').val();
    data.zona = $('select[name="filter_zona"]').val();
    data.tgl = $('input[name="filter_tgl"]').val();
  });

  $('#display').click( function () {
    tableMaster.ajax.reload();
    tableCurrent.ajax.reload();
  });

  $("#chk-all").change(function() {
    for($i = 0; $i < tableMaster.rows().count(); $i++) {
      var no = $i + 1;
      var data = tableMaster.cell($i, 1).data();
      var posisi = data.indexOf("chk");
      var target = data.substr(0, posisi);
      target = target.replace('<input type="checkbox" name="', '');
      target = target.replace("<input type='checkbox' name='", '');
      target = target.replace("<input type='checkbox' name=", '');
      target = target.replace('<input name="', '');
      target = target.replace("<input name='", '');
      target = target.replace("<input name=", '');
      target = target +'chk';
      if(document.getElementById(target) != null) {
        document.getElementById(target).checked = this.checked;
      }
    }
  });

  $("#chk-all2").change(function() {
    for($i = 0; $i < tableCurrent.rows().count(); $i++) {
      var no = $i + 1;
      var data = tableCurrent.cell($i, 1).data();
      var posisi = data.indexOf("chk");
      var target = data.substr(0, posisi);
      target = target.replace('<input type="checkbox" name="', '');
      target = target.replace("<input type='checkbox' name='", '');
      target = target.replace("<input type='checkbox' name=", '');
      target = target.replace('<input name="', '');
      target = target.replace("<input name='", '');
      target = target.replace("<input name=", '');
      target = target +'chk';
      if(document.getElementById(target) != null) {
        document.getElementById(target).checked = this.checked;
      }
    }
  });

  $('#display').click();
});

</script>
@endsection