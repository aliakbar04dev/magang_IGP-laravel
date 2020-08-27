@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Saldo Pengobatan
        <small>Saldo Pengobatan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Employee Info</li>
        <li class="active"><i class="fa fa-files-o"></i> Saldo Pengobatan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_header">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Header</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>Periode</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $v_obat->periode }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Adj. Limit</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ numberFormatter(0, 2)->format($v_obat->adj_limit) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Limit</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ numberFormatter(0, 2)->format($v_obat->limit_obat) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Pemakaian</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ numberFormatter(0, 2)->format($v_obat->pemakaian) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Alokasi BPJS</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ numberFormatter(0, 2)->format($v_obat->nilai_bpjs_kes) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Sisa Saldo</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td><b>{{ numberFormatter(0, 2)->format($v_obat->saldo) }}</b></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style='width: 1%;'>No</th>
                    <th style='width: 10%;'>Tgl Input</th>
                    <th style='width: 25%;'>Pasien</th>
                    <th style='width: 5%;'>Pengobatan</th>
                    <th style='width: 5%;'>Perawatan</th>
                    <th style='width: 5%;'>Kacamata</th>
                    <th>Keterangan</th>
                    <th>No. Dokumen</th>
                    <th>Tgl Dokumen</th>
                    <th>Tgl Transfer</th>
                    <th>Tgl Sync</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
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
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row" id="field_detail2">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Batas Klaim Kacamata</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblDetail2" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style='width: 1%;'>No</th>
                    <th>Nama</th>
                    <th style='width: 20%;'>Batas Klaim Frame</th>
                    <th style='width: 20%;'>Batas Klaim Lensa</th>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){

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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('mobiles.dashboardsaldoobat') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'tgl_entry', name: 'tgl_entry', className: "dt-center"},
        {data: 'nama_pasien', name: 'nama_pasien'},
        {data: 'pengobatan', name: 'pengobatan', className: "dt-right"},
        {data: 'perawatan', name: 'perawatan', className: "dt-right"},
        {data: 'kacamata', name: 'kacamata', className: "dt-right"},
        {data: 'ket', name: 'ket'},
        {data: 'no_doc', name: 'no_doc', className: "none"},
        {data: 'tgl_doc', name: 'tgl_doc', className: "none"},
        {data: 'tgl_transfer', name: 'tgl_transfer', className: "none"},
        {data: 'tgl_sync', name: 'tgl_sync', className: "none", orderable: false, searchable: false}
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

        var column = 3;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 4;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 5;
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

    var tableDetail2 = $('#tblDetail2').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
      render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
      }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('mobiles.dashboardsaldoobat2') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'nama', name: 'nama', orderable: false, searchable: false},
        {data: 'vframe', name: 'vframe', orderable: false, searchable: false},
        {data: 'vlensa', name: 'vlensa', orderable: false, searchable: false}
      ]
    });
  });
</script>
@endsection