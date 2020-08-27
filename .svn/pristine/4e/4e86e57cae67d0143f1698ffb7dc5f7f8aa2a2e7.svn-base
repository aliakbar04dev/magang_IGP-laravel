@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Training Record Member
        <small>Training Record Member</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Employee Info</li>
        <li class="active"><i class="fa fa-files-o"></i> Training Record Member</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Training Record Member</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-horizontal">
              <div class="form-group">
                <div class="col-sm-3">
                  {!! Form::label('lblawal', 'Tgl Awal') !!}
                  {!! Form::date('filter_tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl_awal']) !!}
                </div>
                <div class="col-sm-3">
                  {!! Form::label('lblakhir', 'Tgl Akhir') !!}
                  {!! Form::date('filter_tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_tgl_akhir']) !!}
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblusername2', 'Action') !!}
                  <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
            <div class="box-body">
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style='width: 1%;'>No</th>
                    <th style='width: 5%;'>NPK</th>
                    <th style='width: 20%;'>Nama</th>
                    <th>Nama Training</th>
                    <th style='width: 10%;'>Tgl Mulai</th>
                    <th style='width: 10%;'>Jam Mulai</th>
                    <th style='width: 11%;'>Tgl Selesai</th>
                    <th style='width: 11%;'>Jam Selesai</th>
                    <th>PT</th>
                    <th>Site</th>
                    <th>Divisi</th>
                    <th>Departemen</th>
                    <th>Seksi</th>
                    <th>Jabatan</th>
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
      "order": [[6, 'desc'],[4, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('mobiles.dashboardtrainingmember') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'npk', name: 'npk', className: "dt-center"},
        {data: 'nama', name: 'nama'},
        {data: 'nama_training', name: 'nama_training'},
        {data: 'tgl_mulai', name: 'tgl_mulai', className: "dt-center"},
        {data: 'jam_mulai', name: 'jam_mulai', className: "dt-center", orderable: false, searchable: false},
        {data: 'tgl_selesai', name: 'tgl_selesai', className: "dt-center"},
        {data: 'jam_selesai', name: 'jam_selesai', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'kd_pt', name: 'kd_pt', className: "none"},
        {data: 'kode_site', name: 'kode_site', className: "none"},
        {data: 'desc_div', name: 'desc_div', className: "none"},
        {data: 'desc_dep', name: 'desc_dep', className: "none"},
        {data: 'desc_sie', name: 'desc_sie', className: "none"}, 
        {data: 'desc_jab', name: 'desc_jab', className: "none"}
      ]
    });

    $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="filter_tgl_awal"]').val();
      data.tgl_akhir = $('input[name="filter_tgl_akhir"]').val();
    });

    $('#display').click( function () {
      tableDetail.ajax.reload();
    });

    //$('#display').click();
  });
</script>
@endsection