@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gaji & Lembur
        <small>Gaji & Lembur</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-phone"></i> HR - Mobile</li>
        <li class="active"><i class="fa fa-files-o"></i> Gaji & Lembur</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::open(['url' => route('mobiles.prosesgaji'),
          'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}
        {!! Form::hidden('karyawans', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'karyawans']) !!}
        {!! Form::hidden('flags', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'flags']) !!}
        {!! Form::hidden('year', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'year']) !!}
        {!! Form::hidden('month', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'month']) !!}
        {!! Form::hidden('kd_slip', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kd_slip']) !!}
        {!! Form::hidden('kode_sync', base64_encode('MOBILE_GAJI'), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kode_sync']) !!}
        <div class="box box-primary">        
      		<div class="box-body form-horizontal">
            <div class="form-group">
              <div class="col-sm-2">
                {!! Form::label('lblpt', 'PT') !!}
                <select name="filter_status_pt" aria-controls="filter_status" class="form-control select2">
                  <option value="ALL" selected="selected">ALL</option>
                  <option value="IGP">PT. IGP</option>
                  <option value="GKD">PT. GKD</option>
                  <option value="WEP">PT. WEP</option>
                  <option value="AGI">PT. AGI</option>
                </select>
              </div>
              <div class="col-sm-2">
                  {!! Form::label('lbltahun', 'Tahun') !!}
                  <select name="filter_status_tahun" aria-controls="filter_status" 
                    class="form-control select2">
                    @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-2; $i--)
                      @if ($i == \Carbon\Carbon::now()->format('Y'))
                        <option value={{ $i }} selected="selected">{{ $i }}</option>
                      @else
                        <option value={{ $i }}>{{ $i }}</option>
                      @endif
                    @endfor
                  </select>
              </div>
              <div class="col-sm-2">
                {!! Form::label('lblbulan', 'Bulan') !!}
                <select name="filter_status_bulan" aria-controls="filter_status" 
                  class="form-control select2">
                    <option value="01" @if ("01" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                    <option value="02" @if ("02" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                    <option value="03" @if ("03" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                    <option value="04" @if ("04" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                    <option value="05" @if ("05" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                    <option value="06" @if ("06" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                    <option value="07" @if ("07" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                    <option value="08" @if ("08" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                    <option value="09" @if ("09" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                    <option value="10" @if ("10" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                    <option value="11" @if ("11" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                    <option value="12" @if ("12" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
                  </select>
              </div>
            </div>
      		  <div class="form-group">
      		    <div class="col-sm-2">
                {!! Form::label('lblslip', 'Slip') !!}
                <select name="filter_status_slip" aria-controls="filter_status" class="form-control select2">
                  <option value="GAJI" selected="selected">Gaji</option>
                  <option value="LBR">Lembur</option>
                </select>
              </div>
              <div class="col-sm-2">
                {!! Form::label('lblstatus', 'Status Tampil') !!}
                <select name="filter_status_status" aria-controls="filter_status" class="form-control select2">
                  <option value="ALL" selected="selected">ALL</option>
                  <option value="T">Tampil</option>
                  <option value="F">Tidak Tampil</option>
                </select>
              </div>
              <div class="col-sm-2">
                {!! Form::label('lbldisplay', 'Action') !!}
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
                  <th style="text-align: center;width: 2%;"><input type="checkbox" name="chk-all" id="chk-all"></th>
                  <th style="width: 5%;">NPK</th>
                  <th>Nama</th>
                  <th>PT</th>
                  <th style="width: 15%;">THP 25</th>
                  <th style="width: 15%;">THP 10</th>
                  <th>Divisi</th>
                  <th>Departemen</th>
                  <th>Slip</th>
                  <th>Tgl Sync</th>
                  <th>Status Tampil</th>
                  <th style="width: 5%;">Slip</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>Total</th>
                  <th>Total</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <div>
          {!! Form::submit('Tampilkan / Sembunyikan', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
          &nbsp;&nbsp;
          <button id="btn-sync" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Sinkronisasi (Oracle to PostgreSql)"><span class="glyphicon glyphicon-refresh"></span> Sinkronisasi (Oracle to PostgreSql)</button>
          &nbsp;&nbsp;
          <button id="btn-download" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Download to Excel"><span class="glyphicon glyphicon-download-alt"></span> Download to Excel</button>
          @if (Auth::user()->username === "14438")
            &nbsp;&nbsp;
            <a class="btn btn-danger" href="{{ route('mobiles.lembur') }}" data-toggle="tooltip" data-placement="top" title="Data Lembur">Data Lembur</a>
            &nbsp;&nbsp;
            <a class="btn btn-danger" href="{{ route('mobiles.lemburoracle') }}" data-toggle="tooltip" data-placement="top" title="Data Lembur">Data Lembur Oracle</a>
            &nbsp;&nbsp;
            <a class="btn btn-danger" href="{{ route('mobiles.thporacle') }}" data-toggle="tooltip" data-placement="top" title="Data Lembur">Data THP Oracle</a>
          @endif
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

$("#btn-download").click(function(){
  var tahun = $('select[name="filter_status_tahun"]').val();
  var bulan = $('select[name="filter_status_bulan"]').val();
  var pt = $('select[name="filter_status_pt"]').val();
  var slip = $('select[name="filter_status_slip"]').val();
  var status = $('select[name="filter_status_status"]').val();
  var urlRedirect = '{{ route('mobiles.downloadgaji', ['param', 'param2', 'param3', 'param4', 'param5']) }}';
  urlRedirect = urlRedirect.replace('param5', window.btoa(slip));
  urlRedirect = urlRedirect.replace('param4', window.btoa(status));
  urlRedirect = urlRedirect.replace('param3', window.btoa(pt));
  urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
  urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
  window.location.href = urlRedirect;
});

$("#btn-sync").click(function(){

  var year = $('select[name="filter_status_tahun"]').val();
  var month = $('select[name="filter_status_bulan"]').val();
  var periode = year + "" + month;
  var kd_slip = $('select[name="filter_status_slip"]').val();
  var kd_slip_desc = kd_slip;
  if(kd_slip === "LBR") {
    kd_slip_desc = "LEMBUR";
  }
  var msg = "Anda yakin Sinkronisasi data " + kd_slip_desc + " Periode " + periode + "?";
  var txt = "setelah sinkron Sinkronisasi semua data menjadi TIDAK TAMPIL.";
  swal({
    title: msg,
    text: txt,
    type: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, sync it!',
    cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
    allowOutsideClick: true,
    allowEscapeKey: true,
    allowEnterKey: true,
    reverseButtons: false,
    focusCancel: true,
  }).then(function () {
    var kode_sync = document.getElementById("kode_sync").value;
    var urlRedirect = "{{ route('syncs.tiga', ['param','param2','param3']) }}";
    urlRedirect = urlRedirect.replace('param3', window.btoa(periode));
    urlRedirect = urlRedirect.replace('param2', window.btoa(kd_slip));
    urlRedirect = urlRedirect.replace('param', kode_sync);
    window.location.href = urlRedirect;
  }, function (dismiss) {
    if (dismiss === 'cancel') {
      //
    }
  })
});

$('#form_id').submit(function (e, params) {
  var localParams = params || {};
  if (!localParams.send) {
    e.preventDefault();
    var year = document.getElementById("year").value;
    var month = document.getElementById("month").value;
    var kd_slip = document.getElementById("kd_slip").value;
    var kd_slip_desc = kd_slip;
    if(kd_slip === "LBR") {
      kd_slip_desc = "LEMBUR";
    }
    var validasi = "F";
    var ids = "-";
    var jmldata = 0;
    var table = $('#tblMaster').DataTable();
    table.search('').columns().search('').draw();
    for($i = 0; $i < table.rows().count(); $i++) {
      var no = $i + 1;
      var data = table.cell($i, 1).data();
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
        var checkedOld = document.getElementById(target).checked;
        data = data.replace(target, 'row-' + no + '-chk');
        data = data.replace(target, 'row-' + no + '-chk');
        table.cell($i, 1).data(data);
        posisi = data.indexOf("chk");
        target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        document.getElementById(target).checked = checkedOld;
        var checked = document.getElementById(target).checked;
        if(checked == true) {
          var npk = document.getElementById(target).value.trim();
          validasi = "T";
          if(ids === '-') {
            ids = npk;
          } else {
            ids = ids + "#quinza#" + npk;
          }
          jmldata = jmldata + 1;
        }
      }
    }
    
    if(validasi === "T") {
      //additional input validations can be done hear
      swal({
        title: 'Tampilkan / Sembunyikan?',
        text: 'Jumlah Data: ' + jmldata + ', Tahun: ' + year + ', Bulan: ' + month + ', Slip: ' + kd_slip_desc,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="glyphicon glyphicon-eye-open"></i> Tampilkan!',
        cancelButtonText: '<i class="glyphicon glyphicon-eye-close"></i> Sembunyikan!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: false,
      }).then(function () {
        // swal(
        //   'Deleted!',
        //   'Your file has been deleted.',
        //   'success'
        // )
        //remove these events;
        //window.onkeydown = null;
        //window.onfocus = null;
        // ids = window.btoa(ids);
        document.getElementById("karyawans").value = ids;
        document.getElementById("flags").value = "T";
        $(e.currentTarget).trigger(e.type, { 'send': true });
      }, function (dismiss) {
        if (dismiss === 'cancel') {
          document.getElementById("karyawans").value = ids;
          document.getElementById("flags").value = "F";
          $(e.currentTarget).trigger(e.type, { 'send': true });
        }
      })
    } else {
      swal("Tidak ada data yang dipilih!", "", "warning");
    }
  }
});

$(document).ready(function(){

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
    // "searching": false,
    // "scrollX": true,
    // "scrollY": "700px",
    // "scrollCollapse": true,
    // "paging": false,
    // "lengthChange": false,
    // "ordering": true,
    // "info": true,
    // "autoWidth": false,
    "order": [[2, 'asc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: "{{ route('mobiles.dashboardgaji') }}",
    columns: [
      {data: null, name: null},
      {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false},
      {data: 'npk_asli', name: 'npk_asli'},
      {data: 'nama', name: 'nama'},
      {data: 'kd_pt', name: 'kd_pt', className: "none"},
      {data: 'thp_25', name: 'thp_25', className: "dt-right"},
      {data: 'thp_10', name: 'thp_10', className: "dt-right"},
      {data: 'divisi', name: 'divisi', className: "none"},
      {data: 'departemen', name: 'departemen', className: "none"},
      {data: 'kd_slip', name: 'kd_slip', className: "none"},
      {data: 'tgl_sync', name: 'tgl_sync', className: "none", orderable: false, searchable: false},
      {data: 'st_tampil', name: 'st_tampil', className: "none", orderable: false, searchable: false},
      {data: 'print', name: 'print', orderable: false, searchable: false}
    ], 
    "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api(), data;

      // Remove the formatting to get integer data for summation
      var intVal = function (i) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
      };

      var column = 5;
      total = api.column(column).data().reduce( function (a, b) {
        return intVal(a) + intVal(b);
      },0);
      total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
      $(api.column(column).footer() ).html(
        // 'Total OK: '+ pageTotal + ' ('+ total +')'
        '<p align="right">' + total + '</p>'
      );

      var column = 6;
      total = api.column(column).data().reduce( function (a, b) {
        return intVal(a) + intVal(b);
      },0);
      total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
      $(api.column(column).footer() ).html(
        // 'Total OK: '+ pageTotal + ' ('+ total +')'
        '<p align="right">' + total + '</p>'
      );
    }
  });

  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
    data.tahun = $('select[name="filter_status_tahun"]').val();
    data.bulan = $('select[name="filter_status_bulan"]').val();
    data.pt = $('select[name="filter_status_pt"]').val();
    data.slip = $('select[name="filter_status_slip"]').val();
    data.status = $('select[name="filter_status_status"]').val();
  });

  $('#display').click( function () {
    document.getElementById("year").value = $('select[name="filter_status_tahun"]').val();
    document.getElementById("month").value = $('select[name="filter_status_bulan"]').val();
    document.getElementById("kd_slip").value = $('select[name="filter_status_slip"]').val();
    tableMaster.ajax.reload();
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

  $('#display').click();
});
</script>
@endsection