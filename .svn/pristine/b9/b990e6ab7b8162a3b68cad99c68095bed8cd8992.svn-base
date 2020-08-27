@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Monitoring Total PO BAAN vs E-PO
        <small>PO BAAN vs E-PO</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PO</li>
        <li class="active"><i class="fa fa-files-o"></i> Monitoring Total PO</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Total PO BAAN vs E-PO</h3>
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
            <div class="col-sm-2">
              {!! Form::label('lbldisplay', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbldownload', 'Action') !!}
              <button id="btn-download" type="button" class="form-control btn btn-success" data-toggle="tooltip" data-placement="top" title="Download">Download Excel</button>
            </div>
          </div>
          <!-- /.form-group -->
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th rowspan="2" style="text-align:center;width: 14%;">PO BAAN</th>
                <th rowspan="2" style="text-align:center;width: 14%;">E-PO</th>
                <th rowspan="2" style="text-align:center;width: 12%;">PIC</th>
                <th rowspan="2" style="text-align:center;width: 12%;">SH</th>
                <th rowspan="2" style="text-align:center;width: 12%;">DEP</th>
                <th rowspan="2" style="text-align:center;width: 12%;">DIV</th>
                <th colspan="2" style="text-align:center;">STATUS CETAK</th>
              </tr>
              <tr>
                <th style="text-align:center;width: 12%;">SUDAH</th>
                <th style="text-align:center;width: 12%;">BELUM</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-body">
          <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th rowspan="2" style="text-align:center;width: 5%;">No</th>
                <th rowspan="2" style="text-align:center;width: 10%;">No. PO</th>
                <th rowspan="2" style="text-align:center;">Supplier</th>
                <th rowspan="2" style="text-align:center;width: 7%;">PO BAAN</th>
                <th rowspan="2" style="text-align:center;width: 7%;">E-PO</th>
                <th rowspan="2" style="text-align:center;width: 5%;">PIC</th>
                <th rowspan="2" style="text-align:center;width: 5%;">SH</th>
                <th rowspan="2" style="text-align:center;width: 5%;">DEP</th>
                <th rowspan="2" style="text-align:center;width: 5%;">DIV</th>
                <th colspan="2" style="text-align:center;">STATUS CETAK</th>
              </tr>
              <tr>
                <th style="text-align:center;width: 5%;">SUDAH</th>
                <th style="text-align:center;width: 5%;">BELUM</th>
              </tr>
            </thead>
          </table>
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

  $(document).ready(function(){

    var tableMaster = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "searching": false,
      "paging": false,
      "info": false,
      ajax: "{{ route('baanpo1s.dashboardmonitoringtotal') }}",
      columns: [
        {data: 'jml_po_baan', name: 'jml_po_baan', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_epo', name: 'jml_po_epo', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_pic', name: 'jml_po_pic', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_sh', name: 'jml_po_sh', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_dep', name: 'jml_po_dep', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_div', name: 'jml_po_div', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_portal_print', name: 'jml_po_portal_print', className: "dt-right", orderable: false, searchable: false}, 
        {data: 'jml_po_portal_noprint', name: 'jml_po_portal_noprint', className: "dt-right", orderable: false, searchable: false}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="filter_tgl_awal"]').val();
      data.tgl_akhir = $('input[name="filter_tgl_akhir"]').val();
    });

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
      ajax: "{{ route('baanpo1s.dashboardmonitoringtotalpo') }}",
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'no_po', name: 'no_po', className: "dt-center"}, 
        {data: 'nm_supp', name: 'nm_supp'}, 
        {data: 'po_baan', name: 'po_baan', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'po_epo', name: 'po_epo', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'po_pic', name: 'po_pic', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'po_sh', name: 'po_sh', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'po_dep', name: 'po_dep', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'po_div', name: 'po_div', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'po_portal_print', name: 'po_portal_print', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'po_portal_noprint', name: 'po_portal_noprint', className: "dt-center", orderable: false, searchable: false}
      ],
    });

    $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="filter_tgl_awal"]').val();
      data.tgl_akhir = $('input[name="filter_tgl_akhir"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
      tableDetail.ajax.reload();
    });

    $("#btn-download").click(function(){
      var tgl_awal = $('input[name="filter_tgl_awal"]').val();
      var tgl_akhir = $('input[name="filter_tgl_akhir"]').val();
      var urlRedirect = '{{ route('baanpo1s.downloadmonitoringtotalpo', ['param', 'param2']) }}';
      urlRedirect = urlRedirect.replace('param2', window.btoa(tgl_akhir));
      urlRedirect = urlRedirect.replace('param', window.btoa(tgl_awal));
      window.location.href = urlRedirect;
    });

    // $('#display').click();
  });
</script>
@endsection