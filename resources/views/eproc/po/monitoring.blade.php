@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Monitoring PO Portal
        <small>Progress Print PO</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PO</li>
        <li class="active"><i class="fa fa-files-o"></i> Monitoring PO Portal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::hidden('tgl_awal_h', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_awal_h']) !!}
      {!! Form::hidden('tgl_akhir_h', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_akhir_h']) !!}
      {!! Form::hidden('kode_sync', base64_encode('BAAN_PO'), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kode_sync']) !!}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Progress Print PO</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lblawal', 'Tgl Awal') !!}
              {!! Form::date('filter_tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl_awal']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblakhir', 'Tgl Akhir') !!}
              {!! Form::date('filter_tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_tgl_akhir']) !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-4">
              {!! Form::label('lblsupplier', 'Supplier') !!}
              <select name="filter_supplier" name="filter_supplier" aria-controls="filter_status" class="form-control select2">
                @if (strlen(Auth::user()->username) <= 5)
                  <option value="ALL" selected="selected">ALL</option>
                @endif
                @foreach ($suppliers->get() as $supplier)
                  <option value={{ $supplier->kd_supp }}>{{ $supplier->nama.' - '.$supplier->kd_supp }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbldisplay', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblusername3', 'Sync') !!}
              <button id="btn-sync" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Sinkronisasi (BAAN to IGPro)"><span class="glyphicon glyphicon-refresh"></span> Sinkronisasi (BAAN to IGPro)</button>
            </div>
          </div>
          <!-- /.form-group -->
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th rowspan="2" style="width: 5%;">No</th>
                <th rowspan="2">Supplier</th>
                <th rowspan="2" style="width: 10%;">BAAN</th>
                <th rowspan="2" style="width: 10%;">IGPro</th>
                <th colspan="3" style="text-align:center;">Portal</th>
                <th rowspan="2">Kode Supplier</th>
              </tr>
              <tr>
                <th style="width: 5%;">Total</th>
                <th style="width: 5%;">Cetak</th>
                <th style="width: 5%;">Belum</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">
                    <p>
                      <label id="info-detail">Detail</label>
                    </p>
                  </h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>No. PO</th>
                        <th style="width: 10%;">BAAN</th>
                        <th style="width: 10%;">IGPro</th>
                        <th style="width: 10%;">Portal</th>
                        <th style="width: 10%;">Print</th>
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
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("filter_tgl_awal").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-sync").click(function(){

    var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    var date_awal = new Date($('input[name="filter_tgl_awal"]').val());
    var tgl_awal;
    if(date_awal.getDate() < 10) {
      tgl_awal = "0" + date_awal.getDate();
    } else {
      tgl_awal = date_awal.getDate();
    }
    var periode_awal_name = tgl_awal + " " + monthNames[date_awal.getMonth()] + " " + date_awal.getFullYear();
    var periode_awal;
    if((date_awal.getMonth() + 1) < 10) {
      periode_awal = date_awal.getFullYear() + "0" + (date_awal.getMonth() + 1) + "" + tgl_awal;
    } else {
      periode_awal = date_awal.getFullYear() + "" + (date_awal.getMonth() + 1) + "" + tgl_awal;
    }

    var date_akhir = new Date($('input[name="filter_tgl_akhir"]').val());
    var tgl_akhir;
    if(date_akhir.getDate() < 10) {
      tgl_akhir = "0" + date_akhir.getDate();
    } else {
      tgl_akhir = date_akhir.getDate();
    }
    var periode_akhir_name = tgl_akhir + " " + monthNames[date_akhir.getMonth()] + " " + date_akhir.getFullYear();
    var periode_akhir;
    if((date_akhir.getMonth() + 1) < 10) {
      periode_akhir = date_akhir.getFullYear() + "0" + (date_akhir.getMonth() + 1) + "" + tgl_akhir;
    } else {
      periode_akhir = date_akhir.getFullYear() + "" + (date_akhir.getMonth() + 1) + "" + tgl_akhir;
    }

    if(periode_awal != periode_akhir) {
      swal("Tgl Awal harus sama dengan Tgl Akhir!", "Perhatikan inputan anda!", "error");
    } else {
      var msg = "Anda yakin Sinkronisasi data PO Tgl: " + periode_awal_name + " s/d " + periode_akhir_name + "?";
      var txt = "";
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
        urlRedirect = urlRedirect.replace('param3', window.btoa(periode_akhir));
        urlRedirect = urlRedirect.replace('param2', window.btoa(periode_awal));
        urlRedirect = urlRedirect.replace('param', kode_sync);
        window.location.href = urlRedirect;
      }, function (dismiss) {
        if (dismiss === 'cancel') {
          //
        }
      })
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
      "iDisplayLength": 5,
      responsive: true,
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('baanpo1s.dashboardmonitoring') }}",
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'nm_supp', name: 'nm_supp'}, 
        {data: 'jml_po_baan', name: 'jml_po_baan', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_igpro', name: 'jml_po_igpro', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_portal', name: 'jml_po_portal', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_portal_print', name: 'jml_po_portal_print', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_portal_noprint', name: 'jml_po_portal_noprint', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'kd_supp', name: 'kd_supp', className: "none"}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'DETAIL per-PO';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var nm_supp = tableMaster.cell(index, 1).data();
          var kd_supp = tableMaster.cell(index, 7).data();
          document.getElementById("info-detail").innerHTML = 'DETAIL per-PO (' + nm_supp + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(kd_supp.replace(regex, "")));
        }
      }
    });

    var urlDetail = '{{ route('baanpo1s.detailmonitoring', ['param','param2','param3']) }}';
    urlDetail = urlDetail.replace('param3', "-");
    urlDetail = urlDetail.replace('param2', window.btoa($('input[name="filter_tgl_akhir"]').val()));
    urlDetail = urlDetail.replace('param', window.btoa($('input[name="filter_tgl_awal"]').val()));
    var tableDetail = $('#tblDetail').DataTable({
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
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: urlDetail,
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'no_po', name: 'no_po'}, 
        {data: 'baan', name: 'baan', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'igpro', name: 'igpro', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'portal', name: 'portal', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'print', name: 'print', className: "dt-center", orderable: false, searchable: false}
      ],
    });

    function initTable(kd_supp) {
      var tgl_awal = document.getElementById("tgl_awal_h").value.trim();
      var tgl_akhir = document.getElementById("tgl_akhir_h").value.trim();
      var urlDetail = '{{ route('baanpo1s.detailmonitoring', ['param','param2','param3']) }}';
      urlDetail = urlDetail.replace('param3', kd_supp);
      urlDetail = urlDetail.replace('param2', window.btoa(tgl_akhir));
      urlDetail = urlDetail.replace('param', window.btoa(tgl_awal));
      tableDetail.ajax.url(urlDetail).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="filter_tgl_awal"]').val();
      data.tgl_akhir = $('input[name="filter_tgl_akhir"]').val();
      data.kd_supp = $('select[name="filter_supplier"]').val();
    });

    $('#display').click( function () {
      document.getElementById("tgl_awal_h").value = $('input[name="filter_tgl_awal"]').val();
      document.getElementById("tgl_akhir_h").value = $('input[name="filter_tgl_akhir"]').val();
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'));
        }
      });
    });

    // $('#display').click();
  });
</script>
@endsection