@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        History Pembelian
        <small>History Pembelian</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - LAPORAN - PO</li>
        <li class="active"><i class="fa fa-files-o"></i> History Pembelian</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Item</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 1%;">No</th>
                <th style="width: 15%;">Item No</th>
                <th>Description</th>
                <th style="width: 5%;">Satuan</th>
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
                  <h3 class="box-title"><p id="info-detail">History Harga</p></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 1%;">No</th>
                        <th style="width: 10%;">No. PO</th>
                        <th style="width: 10%;">Tgl PO</th>
                        <th style="width: 12%;">Tgl Kirim</th>
                        <th>Supplier</th>
                        <th style="width: 5%;">MU</th>
                        <th style="width: 12%;">Harga Unit</th>
                        <th style="width: 10%;">QTY PO</th>
                        <th style="width: 10%;">QTY LPB</th>
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
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('baanpo1s.dashboardhistory') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'item', name: 'item'},
        {data: 'desc1', name: 'desc1'},
        {data: 'unit', name: 'unit', className: "dt-center"}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'History Harga';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var item = tableMaster.cell(index, 1).data();
          var desc = tableMaster.cell(index, 2).data();
          var info = item + " - " + desc;
          document.getElementById("info-detail").innerHTML = 'History Harga (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(item.replace(regex, "")));
        }
      }
    });

    var url = '{{ route('baanpo1s.history', ['param','param2']) }}';
    url = url.replace('param2', window.btoa("01/01/1970"));
    url = url.replace('param', window.btoa("-"));
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
      "iDisplayLength": 5,
      responsive: true,
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'no_po', name: 'no_po', className: "dt-center"},
        { data: 'tgl_po', name: 'tgl_po', className: "dt-center"},
        { data: 'ddat', name: 'ddat', className: "dt-center"},
        { data: 'supplier', name: 'supplier'},
        { data: 'kd_curr', name: 'kd_curr', className: "dt-center"},
        { data: 'hrg_unit', name: 'hrg_unit', className: "dt-right"}, 
        { data: 'qty_po', name: 'qty_po', className: "dt-right"}, 
        { data: 'qty_lpb', name: 'qty_lpb', className: "dt-right"}
      ],
    });

    function initTable(data) {
      var tgl = "{{ \Carbon\Carbon::now()->format('d/m/Y') }}";
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('baanpo1s.history', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(tgl));
      url = url.replace('param', data);
      tableDetail.ajax.url(url).load();
    }

    if(tableMaster.rows().count() > 0) {
      $('#tblMaster tbody tr:eq(0)').click(); 
    }
  });

  setTimeout(function(){
    var tableMaster = $('#tblMaster').DataTable();
    if(tableMaster.rows().count() > 0) {
      $('#tblMaster tbody tr:eq(0)').click(); 
    }
  }, 2000);
</script>
@endsection