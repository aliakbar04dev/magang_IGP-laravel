@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Saldo Cuti
        <small>Saldo Cuti</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Employee Info</li>
        <li class="active"><i class="fa fa-files-o"></i> Saldo Cuti</li>
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
                    <td style="width: 15%;"><b>NPK</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->npk }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>NAMA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->nama }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>PT</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kd_pt }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>BAGIAN</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->desc_div }} / {{ $mas_karyawan->desc_dep }} / {{ $mas_karyawan->desc_sie }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>TGL MASUK IGP GROUP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($mas_karyawan->tgl_masuk_gkd)->format('d-m-Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>TGL MASUK</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($mas_karyawan->tgl_masuk)->format('d-m-Y') }}</td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Sisa Cuti Tahunan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td><b>{{ $saldocuti->ct_akhir }} Hari</b></td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Sisa Cuti Besar</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td><b>{{ $saldocuti->cb_akhir }} Hari</b></td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>TGL SYNC</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td><b>{{ \Carbon\Carbon::parse($saldocuti->tgl_sync)->format('d-m-Y H:i:s') }}</b></td>
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
                    <th rowspan="2" style='width: 1%;text-align: center'>No</th>
                    <th rowspan="2" style='width: 7%;text-align: center'>Tahun</th>
                    <th rowspan="2">Bulan</th>
                    <th colspan="4" style='text-align: center'>Cuti Tahunan</th>
                    <th colspan="4" style='text-align: center'>Cuti Besar</th>
                  </tr>
                  <tr>
                    <th style='width: 7%;text-align: center'>Awal</th>
                    <th style='width: 7%;text-align: center'>In</th>
                    <th style='width: 7%;text-align: center'>Out</th>
                    <th style='width: 7%;text-align: center'>Akhir</th>
                    <th style='width: 7%;text-align: center'>Awal</th>
                    <th style='width: 7%;text-align: center'>In</th>
                    <th style='width: 7%;text-align: center'>Out</th>
                    <th style='width: 7%;text-align: center'>Akhir</th>
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
      ajax: "{{ route('mobiles.dashboardsaldocuti') }}",
      columns: [
        {data: null, name: null, className: "dt-center", orderable: false, searchable: false},
        {data: 'tahun', name: 'tahun', className: "dt-center", orderable: false, searchable: false},
        {data: 'bulan', name: 'bulan', orderable: false, searchable: false},
        {data: 'ct_awal', name: 'ct_awal', className: "dt-center", orderable: false, searchable: false},
        {data: 'ct_in', name: 'ct_in', className: "dt-center", orderable: false, searchable: false},
        {data: 'ct_out', name: 'ct_out', className: "dt-center", orderable: false, searchable: false},
        {data: 'ct_akhir', name: 'ct_akhir', className: "dt-center", orderable: false, searchable: false},
        {data: 'cb_awal', name: 'cb_awal', className: "dt-center", orderable: false, searchable: false},
        {data: 'cb_in', name: 'cb_in', className: "dt-center", orderable: false, searchable: false},
        {data: 'cb_out', name: 'cb_out', className: "dt-center", orderable: false, searchable: false},
        {data: 'cb_akhir', name: 'cb_akhir', className: "dt-center", orderable: false, searchable: false}
      ]
    });
  });
</script>
@endsection